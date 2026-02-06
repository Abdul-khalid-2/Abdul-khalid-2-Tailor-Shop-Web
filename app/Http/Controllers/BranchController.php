<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::with(['createdBy', 'updatedBy'])
            ->withCount(['users', 'customers', 'orders', 'tailors'])
            ->latest()
            ->paginate(10);

        $stats = [
            'total' => Branch::count(),
            'active' => Branch::where('is_active', true)->count(),
            'total_users' => User::count(),
            'total_customers' => DB::table('customers')->count(),
        ];

        return view('dashboard.branches.index', compact('branches', 'stats'));
    }

    public function create()
    {
        return view('dashboard.branches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:branches',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'manager_name' => 'nullable|string|max:255',
            'manager_phone' => 'nullable|string|max:20',
            'manager_email' => 'nullable|email|max:255',
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i',
            'working_days' => 'nullable|array',
            'opening_date' => 'nullable|date',
        ]);

        DB::transaction(function () use ($request) {
            $branch = Branch::create([
                'name' => $request->name,
                'code' => $request->code,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'manager_name' => $request->manager_name,
                'manager_phone' => $request->manager_phone,
                'manager_email' => $request->manager_email,
                'opening_time' => $request->opening_time,
                'closing_time' => $request->closing_time,
                'working_days' => $request->working_days,
                'opening_date' => $request->opening_date,
                'is_active' => $request->has('is_active'),
                'created_by' => auth()->id(),
            ]);

            // Create default settings for this branch
            \App\Models\Setting::create([
                'branch_id' => $branch->id,
                'shop_name' => $branch->name,
                'shop_phone' => $branch->phone,
                'shop_email' => $branch->email,
                'shop_address' => $branch->address,
                'currency' => 'PKR',
                'currency_symbol' => 'Rs',
                'default_delivery_days' => 7,
                'tax_rate' => 0,
                'receipt_prefix' => 'TS',
                'next_receipt_number' => 1000,
                'sms_notifications' => true,
                'email_notifications' => true,
                'reminder_days_before' => 1,
                'created_by' => auth()->id(),
            ]);
        });

        return redirect()->route('branches.index')
            ->with('success', 'Branch created successfully.');
    }

    public function show(Branch $branch)
    {
        $branch->load(['createdBy', 'updatedBy', 'setting']);
        $branch->loadCount(['users', 'customers', 'orders', 'tailors', 'fabrics']);

        // Get recent activities
        $recentOrders = $branch->orders()->latest()->limit(5)->get();
        $recentCustomers = $branch->customers()->latest()->limit(5)->get();

        return view('dashboard.branches.show', compact('branch', 'recentOrders', 'recentCustomers'));
    }

    public function edit(Branch $branch)
    {
        return view('dashboard.branches.edit', compact('branch'));
    }

    public function update(Request $request, Branch $branch)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('branches')->ignore($branch->id),
            ],
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'manager_name' => 'nullable|string|max:255',
            'manager_phone' => 'nullable|string|max:20',
            'manager_email' => 'nullable|email|max:255',
            'opening_time' => 'required|date_format:H:i',
            'closing_time' => 'required|date_format:H:i',
            'working_days' => 'nullable|array',
            'opening_date' => 'nullable|date',
        ]);

        $branch->update([
            'name' => $request->name,
            'code' => $request->code,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'manager_name' => $request->manager_name,
            'manager_phone' => $request->manager_phone,
            'manager_email' => $request->manager_email,
            'opening_time' => $request->opening_time,
            'closing_time' => $request->closing_time,
            'working_days' => $request->working_days,
            'opening_date' => $request->opening_date,
            'is_active' => $request->has('is_active'),
            'updated_by' => auth()->id(),
        ]);

        return redirect()->route('branches.show', $branch)
            ->with('success', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch)
    {
        // Check if branch has related records
        if (
            $branch->users()->exists() ||
            $branch->customers()->exists() ||
            $branch->orders()->exists()
        ) {
            return redirect()->back()
                ->with('error', 'Cannot delete branch with existing users, customers, or orders.');
        }

        // Delete branch settings
        $branch->setting()->delete();

        // Delete branch
        $branch->delete();

        return redirect()->route('branches.index')
            ->with('success', 'Branch deleted successfully.');
    }

    public function toggleStatus(Branch $branch)
    {
        $branch->update([
            'is_active' => !$branch->is_active,
            'updated_by' => auth()->id(),
        ]);

        $status = $branch->is_active ? 'activated' : 'deactivated';

        return redirect()->back()
            ->with('success', "Branch {$status} successfully.");
    }
}
