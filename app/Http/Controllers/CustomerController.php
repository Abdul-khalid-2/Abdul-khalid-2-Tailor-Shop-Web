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
        $branches = $this->isSuperAdmin()
            ? Branch::where('is_active', true)->orderBy('name')->get()
            : collect();

        return view('dashboard.customers.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:150',
            'phone'         => ['required', 'string', 'max:20', $this->branchScopedUnique('customers', 'phone')],
            'address'       => 'nullable|string',
            'notes'         => 'nullable|string',
            'branch_id'     => 'nullable|exists:branches,id',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated = $this->enforceBranchId($validated);

        $data = collect($validated)->except('profile_photo')->all();
        $data['created_by'] = auth()->id();

        $customer = Customer::create($data);

        if ($request->hasFile('profile_photo')) {
            $customer->update([
                'profile_photo' => $this->storeBranchImage(
                    $request->file('profile_photo'), 'customer_imgs', $customer->branch_id
                ),
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'customer' => [
                    'id'    => $customer->id,
                    'name'  => $customer->name,
                    'phone' => $customer->phone,
                ],
            ], 201);
        }

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
        $branches = $this->isSuperAdmin()
            ? Branch::where('is_active', true)->orderBy('name')->get()
            : collect();

        return view('dashboard.customers.edit', compact('customer', 'branches'));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:150',
            'phone'         => ['required', 'string', 'max:20', $this->branchScopedUnique('customers', 'phone', $customer->id)],
            'address'       => 'nullable|string',
            'notes'         => 'nullable|string',
            'branch_id'     => 'nullable|exists:branches,id',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated = $this->enforceBranchId($validated);

        $data = collect($validated)->except('profile_photo')->all();
        $data['updated_by'] = auth()->id();

        $customer->update($data);

        if ($request->hasFile('profile_photo')) {
            $customer->update([
                'profile_photo' => $this->storeBranchImage(
                    $request->file('profile_photo'), 'customer_imgs', $customer->branch_id, $customer->profile_photo
                ),
            ]);
        }

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Customer updated successfully.');
    }

    public function destroy(Customer $customer)
    {
        if ($customer->orders()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete a customer with existing orders.');
        }

        $this->deleteBranchImage($customer->profile_photo);

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}
