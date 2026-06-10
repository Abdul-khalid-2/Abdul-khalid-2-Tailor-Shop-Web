<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::with('branch')->withCount('orders');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $customers = $query->latest()->paginate(20)->withQueryString();

        return view('dashboard.customers.index', compact('customers'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();

        return view('dashboard.customers.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:150',
            'phone'     => 'required|string|max:20|unique:customers,phone',
            'address'   => 'nullable|string',
            'notes'     => 'nullable|string',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        $validated['created_by'] = auth()->id();

        $customer = Customer::create($validated);

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Customer created successfully.');
    }

    public function show(Customer $customer)
    {
        $customer->load('branch');

        $orders = $customer->orders()
            ->with('status')
            ->withCount('suits')
            ->latest()
            ->paginate(15);

        return view('dashboard.customers.show', compact('customer', 'orders'));
    }

    public function edit(Customer $customer)
    {
        $branches = Branch::where('is_active', true)->get();

        return view('dashboard.customers.edit', compact('customer', 'branches'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:150',
            'phone'     => 'required|string|max:20|unique:customers,phone,' . $customer->id,
            'address'   => 'nullable|string',
            'notes'     => 'nullable|string',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        $validated['updated_by'] = auth()->id();

        $customer->update($validated);

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->orders()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete a customer with existing orders.');
        }

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
