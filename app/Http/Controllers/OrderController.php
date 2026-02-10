<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\DressType;
use App\Models\Tailor;
use App\Models\Fabric;
use App\Models\Measurement;
use App\Models\OrderStatus;
use App\Models\PaymentStatus;
use App\Models\Payment;
use App\Models\Branch;
use App\Models\PaymentMethod;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['customer', 'status', 'paymentStatus', 'branch'])
            ->orderBy('created_at', 'desc');

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by status
        if ($request->has('status_id') && $request->status_id != 'all') {
            $query->where('status_id', $request->status_id);
        }

        // Filter by date range
        if ($request->has('date_range')) {
            $dates = explode(' - ', $request->date_range);
            if (count($dates) == 2) {
                $startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                $endDate = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                $query->whereBetween('order_date', [$startDate, $endDate]);
            }
        }

        $orders = $query->paginate(20);

        // Get statistics
        $stats = $this->getStats();

        // Get all statuses for filter
        $orderStatuses = OrderStatus::where('is_active', true)->get();
        $paymentStatuses = PaymentStatus::where('is_active', true)->get();


        return view('dashboard.orders.index', compact('orders', 'stats', 'orderStatuses', 'paymentStatuses'));
    }

    /**
     * Get order statistics
     */
    private function getStats()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();

        return [
            'total' => Order::count(),
            'pending' => Order::where('status_id', 1)->count(), // Assuming 1 is Pending
            'in_progress' => Order::where('status_id', 3)->count(), // Assuming 3 is In Progress
            'completed' => Order::whereHas('status', function ($q) {
                $q->where('is_completed', true);
            })->count(),
            'revenue_today' => Order::whereDate('order_date', $today)->sum('final_amount'),
            'revenue_month' => Order::where('order_date', '>=', $startOfMonth)->sum('final_amount'),
            'avg_completion_time' => $this->calculateAvgCompletionTime(),
            'top_tailor' => $this->getTopTailor(),
        ];
    }

    private function calculateAvgCompletionTime()
    {
        $completedOrders = Order::whereHas('status', function ($q) {
            $q->where('is_completed', true);
        })->whereNotNull('delivery_date')->get();

        if ($completedOrders->count() == 0) return 0;

        $totalDays = 0;
        foreach ($completedOrders as $order) {
            $totalDays += $order->order_date->diffInDays($order->delivery_date);
        }

        return round($totalDays / $completedOrders->count(), 1);
    }

    private function getTopTailor()
    {
        $topTailor = DB::table('tailor_assignments')
            ->select('tailor_id', DB::raw('COUNT(*) as order_count'))
            ->groupBy('tailor_id')
            ->orderBy('order_count', 'desc')
            ->first();

        if ($topTailor) {
            $tailor = Tailor::find($topTailor->tailor_id);
            return [
                'name' => $tailor?->name ?? 'N/A',
                'orders' => $topTailor->order_count
            ];
        }

        return [
            'name' => 'N/A',
            'orders' => 0
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get customers (use customer_type or create a new active status field)
        // For now, get all customers since there's no status column
        $customers = Customer::orderBy('name')->get();

        $dressTypes = DressType::where('is_active', true)->orderBy('name')->get();

        // Tailors table has status column
        $tailors = Tailor::where('status', 'active')->orderBy('name')->get();

        // Fabrics table has status column
        $fabrics = Fabric::where('status', 'active')->orderBy('name')->get();

        $branches = Branch::where('is_active', true)->orderBy('name')->get();
        $orderStatuses = OrderStatus::where('is_active', true)->get();
        $paymentStatuses = PaymentStatus::where('is_active', true)->get();

        // Generate next order number
        $lastOrder = Order::orderBy('id', 'desc')->first();
        $orderNumber = 'TS-' . str_pad(($lastOrder?->id ?? 0) + 1001, 4, '0', STR_PAD_LEFT);

        // Payment methods
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('dashboard.orders.create', compact(
            'customers',
            'dressTypes',
            'tailors',
            'fabrics',
            'branches',
            'orderStatuses',
            'paymentStatuses',
            'paymentMethods',
            'orderNumber'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'branch_id' => 'required|exists:branches,id',
            'order_date' => 'required|date',
            'delivery_date' => 'required|date|after_or_equal:order_date',
            'dress_type_id' => 'required|exists:dress_types,id',
            'base_price' => 'required|numeric|min:0',
            'fabric_cost' => 'numeric|min:0',
            'stitching_charges' => 'numeric|min:0',
            'additional_charges' => 'numeric|min:0',
            'discount_amount' => 'numeric|min:0',
            'advance_amount' => 'numeric|min:0',
            'notes' => 'nullable|string',
            'internal_notes' => 'nullable|string',
        ]);
        // dd($request->all());
        DB::beginTransaction();

        // try {
        // Calculate total amount
        $totalAmount = $validated['base_price']
            + ($validated['fabric_cost'] ?? 0)
            + ($validated['stitching_charges'] ?? 0)
            + ($validated['additional_charges'] ?? 0)
            - ($validated['discount_amount'] ?? 0);

        $remainingAmount = $totalAmount - ($validated['advance_amount'] ?? 0);

        // Generate order number
        $lastOrder = Order::orderBy('id', 'desc')->first();
        $orderNumber = 'TS-' . str_pad(($lastOrder?->id ?? 0) + 1001, 4, '0', STR_PAD_LEFT);

        // Create order
        $order = Order::create([
            'order_number' => $orderNumber,
            'customer_id' => $validated['customer_id'],
            'branch_id' => $validated['branch_id'],
            'status_id' => 1, // Pending
            'payment_status_id' => ($validated['advance_amount'] ?? 0) > 0 ? 2 : 1, // Partial or Pending
            'order_date' => $validated['order_date'],
            'delivery_date' => $validated['delivery_date'],
            'total_amount' => $totalAmount,
            'advance_amount' => $validated['advance_amount'] ?? 0,
            'remaining_amount' => $remainingAmount,
            'discount_amount' => $validated['discount_amount'] ?? 0,
            'final_amount' => $totalAmount,
            'notes' => $validated['notes'] ?? null,
            'internal_notes' => $validated['internal_notes'] ?? null,
            'order_type' => 'tailoring',
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
        ]);

        // Create order item
        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'dress_type_id' => $validated['dress_type_id'],
            'item_name' => DressType::find($validated['dress_type_id'])->name,
            'quantity' => 1,
            'price' => $validated['base_price'],
            'total' => $validated['base_price'],
            'item_status' => 'pending',
            'item_type' => 'tailoring',
            'instructions' => $validated['notes'] ?? null,
        ]);

        // Add measurements if provided
        if ($request->has('measurements')) {
            $measurementData = $this->prepareMeasurementData($request->measurements, $orderItem->id);
            if ($measurementData) {
                Measurement::create($measurementData);
            }
        }

        // Assign tailor if provided
        if ($request->has('tailor_id') && $request->tailor_id != null) {
            DB::table('tailor_assignments')->insert([
                'order_item_id' => $orderItem->id,
                'tailor_id' => $request->tailor_id,
                'status_id' => 1, // Assigned
                'assign_date' => now(),
                'expected_date' => $validated['delivery_date'],
                'stitching_charge' => $validated['stitching_charges'] ?? 0,
                'advance_paid' => 0,
                'remaining_payment' => $validated['stitching_charges'] ?? 0,
                'assigned_by' => auth()->id(),
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Record payment if advance paid
        if (($validated['advance_amount'] ?? 0) > 0) {
            DB::table('payments')->insert([
                'order_id' => $order->id,
                'payment_method_id' => $request->payment_method_id ?? 1, // Cash
                'amount' => $validated['advance_amount'],
                'previous_balance' => $totalAmount,
                'new_balance' => $remainingAmount,
                'payment_date' => now(),
                'receipt_number' => 'RCPT-' . str_pad(DB::table('payments')->count() + 1001, 5, '0', STR_PAD_LEFT),
                'received_by' => auth()->id(),
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Record order status change
        DB::table('order_status_logs')->insert([
            'order_id' => $order->id,
            'new_status_id' => 1, // Pending
            'changed_by' => auth()->id(),
            'changed_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::commit();

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order created successfully! Order #: ' . $order->order_number);
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return redirect()->back()
        //         ->with('error', 'Error creating order: ' . $e->getMessage())
        //         ->withInput();
        // }
    }

    private function prepareMeasurementData($measurements, $orderItemId)
    {
        $validMeasurements = [];
        foreach ($measurements as $key => $value) {
            if (!empty($value)) {
                $validMeasurements[$key] = $value;
            }
        }

        if (empty($validMeasurements)) return null;

        return [
            'order_item_id' => $orderItemId,
            'height' => $measurements['height'] ?? null,
            'weight' => $measurements['weight'] ?? null,
            'shoulder' => $measurements['shoulder'] ?? null,
            'chest' => $measurements['chest'] ?? null,
            'waist' => $measurements['waist'] ?? null,
            'hips' => $measurements['hips'] ?? null,
            'sleeve_length' => $measurements['sleeve_length'] ?? null,
            'sleeve_width' => $measurements['sleeve_width'] ?? null,
            'collar' => $measurements['collar'] ?? null,
            'bicep' => $measurements['bicep'] ?? null,
            'wrist' => $measurements['wrist'] ?? null,
            'pant_length' => $measurements['pant_length'] ?? null,
            'inseam' => $measurements['inseam'] ?? null,
            'thigh' => $measurements['thigh'] ?? null,
            'knee' => $measurements['knee'] ?? null,
            'bottom' => $measurements['bottom'] ?? null,
            'ankle' => $measurements['ankle'] ?? null,
            'fitting_preferences' => $measurements['fitting_preferences'] ?? null,
            'notes' => $measurements['notes'] ?? null,
            'version' => 1,
            'is_current' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load([
            'customer',
            'status',
            'paymentStatus',
            'branch',
            'items.dressType',
            'items.measurements',
            'items.tailorAssignments.tailor',
            'payments.paymentMethod',
            'payments.receivedBy',
            'statusLogs.newStatus'
        ]);

        // Get measurement templates for this customer
        $measurementTemplates = DB::table('measurement_templates')
            ->where('customer_id', $order->customer_id)
            ->get();
        
        // Corrected: Use 'is_active' column instead of 'status'
        $paymentMethods = PaymentMethod::where('is_active', true)->get();
        
        return view('dashboard.orders.show', compact('order', 'measurementTemplates', 'paymentMethods'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        // Load order with relationships
        $order->load([
            'customer',
            'items.dressType',
            'items.measurements',
            'items.tailorAssignments.tailor'
        ]);

        // Get customers (without status filter since column doesn't exist)
        $customers = Customer::orderBy('name')->get();

        $dressTypes = DressType::where('is_active', true)->orderBy('name')->get();
        $tailors = Tailor::where('status', 'active')->orderBy('name')->get();
        $fabrics = Fabric::where('status', 'active')->orderBy('name')->get();
        $branches = Branch::where('is_active', true)->orderBy('name')->get();
        $orderStatuses = OrderStatus::where('is_active', true)->get();
        $paymentStatuses = PaymentStatus::where('is_active', true)->get();
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        return view('dashboard.orders.edit', compact(
            'order',
            'customers',
            'dressTypes',
            'tailors',
            'fabrics',
            'branches',
            'orderStatuses',
            'paymentStatuses',
            'paymentMethods'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'branch_id' => 'required|exists:branches,id',
            'status_id' => 'required|exists:order_statuses,id',
            'payment_status_id' => 'required|exists:payment_statuses,id',
            'order_date' => 'required|date',
            'delivery_date' => 'required|date|after_or_equal:order_date',
            'total_amount' => 'required|numeric|min:0',
            'advance_amount' => 'required|numeric|min:0',
            'remaining_amount' => 'required|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
            'final_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'internal_notes' => 'nullable|string',
        ]);

        // Check if status changed
        $statusChanged = $order->status_id != $validated['status_id'];

        $validated['updated_by'] = auth()->id();

        $order->update($validated);

        // Log status change if applicable
        if ($statusChanged) {
            DB::table('order_status_logs')->insert([
                'order_id' => $order->id,
                'old_status_id' => $order->getOriginal('status_id'),
                'new_status_id' => $validated['status_id'],
                'changed_by' => auth()->id(),
                'changed_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return redirect()->route('orders.show', $order->id)
            ->with('success', 'Order updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        // Check if order has payments
        if ($order->payments()->exists() && $order->payments()->sum('amount') > 0) {
            return redirect()->route('orders.index')
                ->with('error', 'Cannot delete order with payments. Cancel the order instead.');
        }

        $order->delete();

        return redirect()->route('orders.index')
            ->with('success', 'Order deleted successfully!');
    }

    /**
     * Get orders by status (Pending, In Progress, Completed)
     */
    public function byStatus($statusSlug)
    {
        $status = OrderStatus::where('slug', $statusSlug)->firstOrFail();

        $query = Order::with(['customer', 'status', 'paymentStatus', 'branch'])
            ->where('status_id', $status->id)
            ->orderBy('created_at', 'desc');

        if ($status->is_completed) {
            $query->whereNotNull('delivery_date');
        }

        $orders = $query->paginate(20);

        $stats = [
            'total' => $orders->total(),
            'revenue' => $orders->sum('final_amount'),
            'avg_amount' => $orders->avg('final_amount'),
        ];

        return view('dashboard.orders.status', compact('orders', 'status', 'stats'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status_id' => 'required|exists:order_statuses,id',
            'notes' => 'nullable|string',
        ]);

        $oldStatusId = $order->status_id;
        $newStatusId = $request->status_id;

        DB::beginTransaction();

        try {
            $order->update([
                'status_id' => $newStatusId,
                'updated_by' => auth()->id(),
            ]);

            // Log status change
            DB::table('order_status_logs')->insert([
                'order_id' => $order->id,
                'old_status_id' => $oldStatusId,
                'new_status_id' => $newStatusId,
                'notes' => $request->notes,
                'changed_by' => auth()->id(),
                'changed_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully!',
                'status_name' => OrderStatus::find($newStatusId)->name,
                'status_color' => OrderStatus::find($newStatusId)->color,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Error updating status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get order statistics API
     */
    public function statistics()
    {
        $today = Carbon::today();
        $startOfMonth = Carbon::now()->startOfMonth();
        $startOfWeek = Carbon::now()->startOfWeek();

        return response()->json([
            'total' => Order::count(),
            'pending' => Order::where('status_id', 1)->count(),
            'in_progress' => Order::where('status_id', 3)->count(),
            'completed' => Order::whereHas('status', function ($q) {
                $q->where('is_completed', true);
            })->count(),
            'revenue_today' => Order::whereDate('order_date', $today)->sum('final_amount'),
            'revenue_week' => Order::where('order_date', '>=', $startOfWeek)->sum('final_amount'),
            'revenue_month' => Order::where('order_date', '>=', $startOfMonth)->sum('final_amount'),
            'top_dress_type' => $this->getTopDressType(),
            'recent_orders' => Order::with('customer')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get()
                ->map(function ($order) {
                    return [
                        'id' => $order->id,
                        'order_number' => $order->order_number,
                        'customer_name' => $order->customer->name,
                        'amount' => $order->final_amount,
                        'status' => $order->status->name,
                        'color' => $order->status->color,
                        'time' => $order->created_at->diffForHumans(),
                    ];
                }),
        ]);
    }

    private function getTopDressType()
    {
        $topDressType = DB::table('order_items')
            ->select('dress_type_id', DB::raw('COUNT(*) as order_count'))
            ->groupBy('dress_type_id')
            ->orderBy('order_count', 'desc')
            ->first();

        if ($topDressType) {
            $dressType = DressType::find($topDressType->dress_type_id);
            return [
                'name' => $dressType?->name ?? 'N/A',
                'orders' => $topDressType->order_count
            ];
        }

        return [
            'name' => 'N/A',
            'orders' => 0
        ];
    }

    /**
     * Export orders
     */
    public function export(Request $request)
    {
        $query = Order::with(['customer', 'status', 'paymentStatus', 'branch']);

        if ($request->has('status_id') && $request->status_id != 'all') {
            $query->where('status_id', $request->status_id);
        }

        if ($request->has('date_range')) {
            $dates = explode(' - ', $request->date_range);
            if (count($dates) == 2) {
                $startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                $endDate = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                $query->whereBetween('order_date', [$startDate, $endDate]);
            }
        }

        $orders = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="orders_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($orders) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, [
                'Order #',
                'Customer',
                'Phone',
                'Dress Type',
                'Order Date',
                'Delivery Date',
                'Status',
                'Payment Status',
                'Total Amount',
                'Advance Paid',
                'Balance',
                'Branch',
                'Created At'
            ]);

            // Data
            foreach ($orders as $order) {
                $orderItem = $order->items->first();
                fputcsv($file, [
                    $order->order_number,
                    $order->customer->name,
                    $order->customer->phone,
                    $orderItem?->dressType?->name ?? 'N/A',
                    $order->order_date->format('Y-m-d'),
                    $order->delivery_date?->format('Y-m-d') ?? 'N/A',
                    $order->status->name,
                    $order->paymentStatus->name,
                    $order->final_amount,
                    $order->advance_amount,
                    $order->remaining_amount,
                    $order->branch->name,
                    $order->created_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get customer details for AJAX
     */
    public function getCustomerDetails($id)
    {
        $customer = Customer::with(['measurementTemplates.dressType'])->findOrFail($id);

        return response()->json([
            'customer' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'phone' => $customer->phone,
                'address' => $customer->address,
                'customer_type' => $customer->customer_type,
                'discount_rate' => $customer->discount_rate,
                'measurement_templates' => $customer->measurementTemplates->map(function ($template) {
                    return [
                        'id' => $template->id,
                        'template_name' => $template->template_name,
                        'dress_type' => $template->dressType->name,
                        'measurements' => $template->measurements,
                    ];
                })
            ]
        ]);
    }

    /**
     * Get dress type details for AJAX
     */
    public function getDressTypeDetails($id)
    {
        $dressType = DressType::findOrFail($id);

        return response()->json([
            'dress_type' => [
                'id' => $dressType->id,
                'name' => $dressType->name,
                'base_price' => $dressType->base_price,
                'estimated_days' => $dressType->estimated_days,
                'description' => $dressType->description,
            ]
        ]);
    }


    /**
     * Get pending orders
     */
    public function pending(Request $request)
    {
        $status = OrderStatus::where('slug', 'pending')->firstOrFail();

        $query = Order::with(['customer', 'status', 'paymentStatus', 'branch'])
            ->where('status_id', $status->id)
            ->orderBy('order_date', 'asc'); // Oldest first for pending orders

        return $this->renderStatusView($query, $status, $request);
    }

    /**
     * Get in-progress orders
     */
    public function inProgress(Request $request)
    {
        $status = OrderStatus::where('slug', 'in-progress')->firstOrFail();

        $query = Order::with(['customer', 'status', 'paymentStatus', 'branch'])
            ->where('status_id', $status->id)
            ->orderBy('delivery_date', 'asc'); // Sort by closest delivery date

        return $this->renderStatusView($query, $status, $request);
    }

    /**
     * Get completed orders
     */
    public function completed(Request $request)
    {
        $status = OrderStatus::where('slug', 'delivered')->firstOrFail();

        $query = Order::with(['customer', 'status', 'paymentStatus', 'branch'])
            ->where('status_id', $status->id)
            ->orderBy('delivery_date', 'desc'); // Most recent deliveries first

        return $this->renderStatusView($query, $status, $request);
    }

    /**
     * Helper method to render status-based views
     */
    private function renderStatusView($query, $status, $request)
    {
        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%")
                            ->orWhere('phone', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by date range
        if ($request->has('date_range')) {
            $dates = explode(' - ', $request->date_range);
            if (count($dates) == 2) {
                $startDate = Carbon::createFromFormat('m/d/Y', trim($dates[0]))->startOfDay();
                $endDate = Carbon::createFromFormat('m/d/Y', trim($dates[1]))->endOfDay();
                $query->whereBetween('order_date', [$startDate, $endDate]);
            }
        }

        $orders = $query->paginate(20);

        // Get statistics for this status
        $stats = [
            'total' => $orders->total(),
            'revenue' => $orders->sum('final_amount'),
            'avg_amount' => $orders->avg('final_amount'),
            'this_month' => Order::where('status_id', $status->id)
                ->whereMonth('order_date', Carbon::now()->month)
                ->whereYear('order_date', Carbon::now()->year)
                ->count(),
        ];

        return view('dashboard.orders.status', compact('orders', 'status', 'stats'));
    }

    public function customerStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'email' => 'nullable|email|unique:users,email',
            'address' => 'nullable|string',
            'branch_id' => 'required|exists:branches,id',
            'customer_type' => 'required|in:regular,vip,corporate,walk_in',
        ]);

        try {
            // Define customer variable outside the closure
            $customer = null;

            DB::transaction(function () use ($validated, $request, &$customer) {
                // Create user if email provided
                $user = null;
                if (!empty($validated['email'])) {
                    $password = Str::random(8);
                    $user = User::create([
                        'name' => $validated['name'],
                        'email' => $validated['email'],
                        'phone' => $validated['phone'],
                        'password' => bcrypt($password),
                        'role' => 'customer',
                        'branch_id' => $validated['branch_id'],
                        'status' => 'active',
                    ]);
                }

                // Create customer with only required/important fields
                $customer = Customer::create([
                    'user_id' => $user ? $user->id : null,
                    'name' => $validated['name'],
                    'phone' => $validated['phone'],
                    'address' => $validated['address'] ?? null,
                    'customer_type' => $validated['customer_type'],
                    'discount_rate' => 0, // Default discount rate
                    'branch_id' => $validated['branch_id'],
                    'created_by' => auth()->id(),
                    'preferred_communication' => [],
                    'send_welcome_message' => false,
                ]);
            });

            // Check if customer was created
            if (!$customer) {
                throw new \Exception('Customer creation failed.');
            }

            // Return JSON response for AJAX request
            return response()->json([
                'success' => true,
                'message' => 'Customer created successfully.',
                'customer' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'phone' => $customer->phone,
                    'address' => $customer->address,
                    'customer_type' => $customer->customer_type,
                    'discount_rate' => $customer->discount_rate,
                ]
            ]);
        } catch (\Exception $e) {
            // Handle AJAX error response
            return response()->json([
                'success' => false,
                'message' => 'Error creating customer: ' . $e->getMessage(),
                'errors' => ['general' => $e->getMessage()]
            ], 500);
        }
    }


    public function addPayment(Order $order, Request $request)
    {
        
        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1', 'max:' . $order->remaining_amount],
            'payment_date' => ['required', 'date'],
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'receipt_number' => ['nullable', 'string', 'unique:payments,receipt_number'],
            'reference_number' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
            'received_by' => ['required', 'exists:users,id'],
        ]);

        try {
            DB::transaction(function () use ($order, $validated) {
                // Generate receipt number if not provided
                if (empty($validated['receipt_number'])) {
                    $validated['receipt_number'] = 'RC-' . $order->id . '-' . time();
                }

                // Create payment
                $payment = Payment::create([
                    'order_id' => $order->id,
                    'amount' => $validated['amount'],
                    'payment_date' => $validated['payment_date'],
                    'payment_method_id' => $validated['payment_method_id'],
                    'receipt_number' => $validated['receipt_number'],
                    'reference_number' => $validated['reference_number'] ?? null,
                    'previous_balance' => $order->remaining_amount,
                    'new_balance' => $order->remaining_amount - $validated['amount'],
                    'notes' => $validated['notes'] ?? null,
                    'received_by' => $validated['received_by'],
                    'created_by' => auth()->id(),
                ]);

                // Update order's remaining amount
                $order->remaining_amount = $payment->new_balance;

                // Update payment status
                if ($order->remaining_amount <= 0) {
                    $order->payment_status_id = PaymentStatus::where('slug', 'paid')->first()->id;
                } else {
                    $order->payment_status_id = PaymentStatus::where('slug', 'partial')->first()->id;
                }

                $order->save();

                // Create payment log
                $order->statusLogs()->create([
                    'old_status_id' => $order->payment_status_id,
                    'new_status_id' => $order->payment_status_id,
                    'changed_by' => auth()->id(),
                    'notes' => 'Payment recorded: Rs ' . number_format($validated['amount']) .
                        ' via ' . PaymentMethod::find($validated['payment_method_id'])->name .
                        ' (Receipt: ' . $validated['receipt_number'] . ')',
                ]);

                $this->payment = $payment; // Store for response
            });

            return response()->json([
                'success' => true,
                'message' => 'Payment recorded successfully!',
                'payment' => [
                    'id' => $this->payment->id,
                    'amount' => $this->payment->amount,
                    'receipt_number' => $this->payment->receipt_number,
                    'new_balance' => $this->payment->new_balance,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error recording payment: ' . $e->getMessage(),
                'errors' => ['general' => $e->getMessage()]
            ], 500);
        }
    }
}
