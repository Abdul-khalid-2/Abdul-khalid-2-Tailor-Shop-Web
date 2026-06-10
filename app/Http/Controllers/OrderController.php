<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\OrderStatusLog;
use App\Models\Tailor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /** Measurement fields that may be submitted with an order. */
    private const MEASUREMENT_FIELDS = [
        'length', 'shoulder', 'chest', 'waist', 'hip', 'sleeve', 'collar',
        'trouser_length', 'trouser_waist', 'thigh', 'bottom_opening', 'notes',
    ];

    /*
    |--------------------------------------------------------------------------
    | Listings
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'tailor', 'status']);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($c) use ($search) {
                        $c->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status_id')) {
            $query->where('status_id', $request->status_id);
        }

        $orders = $query->latest()->paginate(20)->withQueryString();
        $statuses = OrderStatus::orderBy('sort_order')->get();

        return view('dashboard.orders.index', compact('orders', 'statuses'));
    }

    public function pending()
    {
        $orders = Order::pending()
            ->with(['customer', 'tailor', 'status'])
            ->orderBy('delivery_date')
            ->paginate(20);

        return view('dashboard.orders.pending', compact('orders'));
    }

    public function inProgress()
    {
        $orders = Order::inProgress()
            ->with(['customer', 'tailor', 'status'])
            ->orderBy('delivery_date')
            ->paginate(20);

        return view('dashboard.orders.in-progress', compact('orders'));
    }

    public function ready()
    {
        $orders = Order::ready()
            ->with(['customer', 'tailor', 'status'])
            ->orderBy('delivery_date')
            ->paginate(20);

        return view('dashboard.orders.ready', compact('orders'));
    }

    public function overdue()
    {
        $orders = Order::overdue()
            ->with(['customer', 'tailor', 'status'])
            ->orderBy('delivery_date')
            ->paginate(20);

        return view('dashboard.orders.overdue', compact('orders'));
    }

    /*
    |--------------------------------------------------------------------------
    | Create / Store
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $customers = Customer::orderBy('name')->get();
        $tailors   = Tailor::active()->orderBy('name')->get();
        $orderDate = today()->toDateString();

        return view('dashboard.orders.create', compact('customers', 'tailors', 'orderDate'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateOrder($request);

        $order = DB::transaction(function () use ($validated, $request) {
            $order = Order::create([
                'customer_id'      => $validated['customer_id'],
                'tailor_id'        => $validated['tailor_id'] ?? null,
                'branch_id'        => $this->resolveBranchId($validated),
                'status_id'        => $this->pendingStatusId(),
                'order_date'       => $validated['order_date'],
                'delivery_date'    => $validated['delivery_date'] ?? null,
                'order_label'      => $validated['order_label'] ?? null,
                'advance_paid'     => $validated['advance_paid'] ?? 0,
                'tailor_fee_total' => $validated['tailor_fee_total'] ?? 0,
                'notes'            => $validated['notes'] ?? null,
                'created_by'       => auth()->id(),
            ]);

            $this->syncSuits($order, $validated['suits']);
            $this->syncMeasurement($order, $request->input('measurement', []));

            OrderStatusLog::create([
                'order_id'      => $order->id,
                'old_status_id' => null,
                'new_status_id' => $order->status_id,
                'changed_by'    => auth()->id(),
                'notes'         => 'Order created',
            ]);

            $order->recalculate();
            $order->tailor?->syncStats();

            return $order;
        });

        return redirect()->route('orders.show', $order)
            ->with('success', "Order {$order->order_number} created successfully.");
    }

    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */
    public function show(Order $order)
    {
        $order->load([
            'customer',
            'tailor',
            'branch',
            'status',
            'suits',
            'measurement',
            'statusLogs' => fn ($q) => $q->latest()->with(['oldStatus', 'newStatus', 'changedBy']),
        ]);

        return view('dashboard.orders.show', compact('order'));
    }

    /*
    |--------------------------------------------------------------------------
    | Edit / Update
    |--------------------------------------------------------------------------
    */
    public function edit(Order $order)
    {
        $order->load(['suits', 'measurement']);
        $customers = Customer::orderBy('name')->get();
        $tailors   = Tailor::active()->orderBy('name')->get();

        return view('dashboard.orders.edit', compact('order', 'customers', 'tailors'));
    }

    public function update(Request $request, Order $order)
    {
        $validated = $this->validateOrder($request);

        DB::transaction(function () use ($validated, $request, $order) {
            $previousTailorId = $order->tailor_id;

            $order->update([
                'customer_id'      => $validated['customer_id'],
                'tailor_id'        => $validated['tailor_id'] ?? null,
                'branch_id'        => $this->resolveBranchId($validated, $order),
                'order_date'       => $validated['order_date'],
                'delivery_date'    => $validated['delivery_date'] ?? null,
                'order_label'      => $validated['order_label'] ?? null,
                'advance_paid'     => $validated['advance_paid'] ?? 0,
                'tailor_fee_total' => $validated['tailor_fee_total'] ?? 0,
                'notes'            => $validated['notes'] ?? null,
                'updated_by'       => auth()->id(),
            ]);

            // Replace suits, then re-sync measurement
            $order->suits()->delete();
            $this->syncSuits($order, $validated['suits']);
            $this->syncMeasurement($order, $request->input('measurement', []));

            $order->recalculate();

            // Keep stats current for both the old and the new tailor
            $order->tailor?->syncStats();
            if ($previousTailorId && $previousTailorId !== $order->tailor_id) {
                Tailor::find($previousTailorId)?->syncStats();
            }
        });

        return redirect()->route('orders.show', $order)
            ->with('success', "Order {$order->order_number} updated successfully.");
    }

    /*
    |--------------------------------------------------------------------------
    | Status + payments
    |--------------------------------------------------------------------------
    */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status_id' => 'required|exists:order_statuses,id',
            'notes'     => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $order) {
            $oldStatusId = $order->status_id;
            $newStatus   = OrderStatus::find($validated['status_id']);

            $order->status_id = $newStatus->id;

            if ($newStatus->name === 'Delivered' && empty($order->actual_delivery_date)) {
                $order->actual_delivery_date = today();
            }

            $order->save();

            OrderStatusLog::create([
                'order_id'      => $order->id,
                'old_status_id' => $oldStatusId,
                'new_status_id' => $newStatus->id,
                'changed_by'    => auth()->id(),
                'notes'         => $validated['notes'] ?? null,
            ]);

            $order->tailor?->syncStats();
        });

        return redirect()->back()->with('success', 'Order status updated.');
    }

    public function recordTailorPayment(Request $request, Order $order)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $order->tailor_fee_paid    = (float) $order->tailor_fee_paid + (float) $validated['amount'];
        $order->tailor_fee_balance = (float) $order->tailor_fee_total - (float) $order->tailor_fee_paid;
        $order->save();

        $order->tailor?->syncStats();

        return redirect()->back()->with('success', 'Tailor payment recorded.');
    }

    public function recordCustomerPayment(Request $request, Order $order)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
        ]);

        $order->advance_paid = (float) $order->advance_paid + (float) $validated['amount'];
        $order->balance_due  = (float) $order->total_amount - (float) $order->advance_paid;
        $order->save();

        return redirect()->back()->with('success', 'Customer payment recorded.');
    }

    /*
    |--------------------------------------------------------------------------
    | Destroy
    |--------------------------------------------------------------------------
    */
    public function destroy(Order $order)
    {
        $statusName = $order->status?->name;

        if (! in_array($statusName, ['Pending', 'Cancelled'], true)) {
            return redirect()->back()
                ->with('error', 'Only Pending or Cancelled orders can be deleted.');
        }

        $tailor = $order->tailor;
        $order->delete();
        $tailor?->syncStats();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */
    private function validateOrder(Request $request): array
    {
        return $request->validate([
            'customer_id'               => 'required|exists:customers,id',
            'tailor_id'                 => 'nullable|exists:tailors,id',
            'branch_id'                 => 'nullable|exists:branches,id',
            'order_date'                => 'required|date',
            'delivery_date'             => 'nullable|date|after_or_equal:order_date',
            'order_label'               => 'nullable|string|max:100',
            'advance_paid'              => 'nullable|numeric|min:0',
            'tailor_fee_total'          => 'nullable|numeric|min:0',
            'notes'                     => 'nullable|string',
            'suits'                     => 'required|array|min:1',
            'suits.*.color'             => 'required|string|max:80',
            'suits.*.quantity'          => 'required|integer|min:1',
            'suits.*.stitching_charge'  => 'nullable|numeric|min:0',
            'suits.*.button_charge'     => 'nullable|numeric|min:0',
            'suits.*.other_charge'      => 'nullable|numeric|min:0',
            'suits.*.other_charge_note' => 'nullable|string|max:200',
            'suits.*.notes'             => 'nullable|string',
            'measurement'               => 'nullable|array',
        ]);
    }

    private function syncSuits(Order $order, array $suits): void
    {
        foreach (array_values($suits) as $i => $suit) {
            $order->suits()->create([
                'color'             => $suit['color'],
                'quantity'          => $suit['quantity'] ?? 1,
                'stitching_charge'  => $suit['stitching_charge'] ?? 0,
                'button_charge'     => $suit['button_charge'] ?? 0,
                'other_charge'      => $suit['other_charge'] ?? 0,
                'other_charge_note' => $suit['other_charge_note'] ?? null,
                'notes'             => $suit['notes'] ?? null,
                'sort_order'        => $i,
            ]);
        }
    }

    private function syncMeasurement(Order $order, array $measurement): void
    {
        $data = array_filter(
            array_intersect_key($measurement, array_flip(self::MEASUREMENT_FIELDS)),
            fn ($v) => $v !== null && $v !== ''
        );

        if (empty($data)) {
            $order->measurement()->delete();
            return;
        }

        $order->measurement()->updateOrCreate(
            ['order_id' => $order->id],
            $data
        );
    }

    private function resolveBranchId(array $validated, ?Order $order = null): int
    {
        if (! empty($validated['branch_id'])) {
            return (int) $validated['branch_id'];
        }

        if ($order && $order->branch_id) {
            return (int) $order->branch_id;
        }

        return (int) (Customer::find($validated['customer_id'])?->branch_id
            ?? auth()->user()?->branch_id
            ?? Branch::value('id'));
    }

    private function pendingStatusId(): int
    {
        return (int) (OrderStatus::where('name', 'Pending')->value('id') ?? 1);
    }
}
