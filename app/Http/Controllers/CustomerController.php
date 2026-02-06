<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Branch;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with(['user', 'branch', 'orders'])
            ->withCount(['orders as total_orders'])
            ->withSum('orders as total_spent', 'final_amount');

        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('reference', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by branch
        if ($request->has('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $customers = $query->latest()->paginate(15);

        // Get stats - FIXED
        $stats = [
            'total' => Customer::count(),
            'active' => Customer::whereHas('orders', function ($q) {
                $q->where('created_at', '>=', now()->subMonth());
            })->count(),
            'new_this_month' => Customer::whereMonth('created_at', now()->month)->count(),
            'avg_orders' => $this->calculateAvgOrders(),
        ];

        $branches = Branch::all();

        return view('dashboard.customers.index', compact('customers', 'stats', 'branches'));
    }

    /**
     * Calculate average orders per customer
     */
    private function calculateAvgOrders()
    {
        // Get customers with orders
        $customersWithOrders = Customer::has('orders')->get();

        if ($customersWithOrders->isEmpty()) {
            return 0;
        }

        // Calculate total orders
        $totalOrders = $customersWithOrders->sum(function ($customer) {
            return $customer->orders()->count();
        });

        // Calculate average
        return round($totalOrders / $customersWithOrders->count(), 1);
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();
        return view('dashboard.customers.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'email' => 'nullable|email|unique:users,email',
            'address' => 'nullable|string',
            'branch_id' => 'required|exists:branches,id',
        ]);

        DB::transaction(function () use ($request) {
            // Create user if email provided
            $user = null;
            if ($request->email) {
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => bcrypt(str_random(8)), // Generate random password
                    'role' => 'customer',
                    'branch_id' => $request->branch_id,
                ]);
            }

            // Create customer
            $customer = Customer::create([
                'user_id' => $user ? $user->id : null,
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'reference' => $request->reference,
                'notes' => $request->notes,
                'branch_id' => $request->branch_id,
                'created_by' => auth()->id(),
            ]);

            // If user was created, update with customer_id
            if ($user) {
                $user->update(['customer_id' => $customer->id]);
            }
        });

        return redirect()->route('customers.index')
            ->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        $customer->load([
            'user',
            'branch',
            'orders' => function ($q) {
                $q->latest()->limit(10);
            },
            'orders.items',
            'orders.payments',
            'measurementTemplates'
        ]);

        $stats = [
            'total_orders' => $customer->orders()->count(),
            'total_spent' => $customer->orders()->sum('final_amount'),
            'avg_order_value' => $customer->orders()->avg('final_amount'),
            'last_order' => $customer->orders()->latest()->first(),
        ];

        return view('dashboard.customers.show', compact('customer', 'stats'));
    }

    public function edit(Customer $customer)
    {
        $branches = Branch::where('is_active', true)->get();
        return view('dashboard.customers.edit', compact('customer', 'branches'));
    }

    public function update(Request $request, Customer $customer)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone,' . $customer->id,
            'email' => 'nullable|email|unique:users,email,' . ($customer->user_id ?: 'NULL'),
            'address' => 'nullable|string',
            'branch_id' => 'required|exists:branches,id',
        ]);

        DB::transaction(function () use ($request, $customer) {
            // Update customer
            $customer->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'reference' => $request->reference,
                'notes' => $request->notes,
                'branch_id' => $request->branch_id,
                'updated_by' => auth()->id(),
            ]);

            // Update or create user
            if ($request->email) {
                if ($customer->user) {
                    $customer->user->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                    ]);
                } else {
                    $user = User::create([
                        'name' => $request->name,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'password' => bcrypt(str_random(8)),
                        'role' => 'customer',
                        'branch_id' => $request->branch_id,
                    ]);
                    $customer->update(['user_id' => $user->id]);
                    $user->update(['customer_id' => $customer->id]);
                }
            }
        });

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        // Check if customer has orders
        if ($customer->orders()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete customer with existing orders.');
        }

        DB::transaction(function () use ($customer) {
            // Delete user if exists
            if ($customer->user) {
                $customer->user->delete();
            }

            // Delete customer
            $customer->delete();
        });

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
