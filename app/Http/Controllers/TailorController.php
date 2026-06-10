<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Tailor;
use Illuminate\Http\Request;

class TailorController extends Controller
{
    public function index(Request $request)
    {
        $query = Tailor::with('branch')
            ->withCount(['orders as active_orders_count' => function ($q) {
                $q->whereHas('status', fn ($s) => $s->whereNotIn('name', ['Delivered', 'Cancelled']));
            }]);

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $tailors = $query->orderBy('name')->paginate(15)->withQueryString();

        return view('dashboard.tailors.index', compact('tailors'));
    }

    public function create()
    {
        $branches = Branch::where('is_active', true)->get();

        return view('dashboard.tailors.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:150',
            'phone'        => 'required|string|max:20|unique:tailors,phone',
            'cnic'         => 'nullable|string|max:20',
            'address'      => 'nullable|string',
            'joining_date' => 'nullable|date',
            'status'       => 'nullable|in:active,on_leave',
            'specialty'    => 'nullable|in:shalwar_kameez,sherwani,all',
            'branch_id'    => 'nullable|exists:branches,id',
            'notes'        => 'nullable|string',
        ]);

        $validated['status'] = $validated['status'] ?? 'active';
        $validated['specialty'] = $validated['specialty'] ?? 'all';

        $tailor = Tailor::create($validated);

        return redirect()->route('tailors.show', $tailor)
            ->with('success', 'Tailor created successfully.');
    }

    public function show(Tailor $tailor)
    {
        $tailor->load([
            'branch',
            'orders' => fn ($q) => $q->latest()->with(['customer', 'status']),
        ]);

        return view('dashboard.tailors.show', compact('tailor'));
    }

    public function edit(Tailor $tailor)
    {
        $branches = Branch::where('is_active', true)->get();

        return view('dashboard.tailors.edit', compact('tailor', 'branches'));
    }

    public function update(Request $request, Tailor $tailor)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:150',
            'phone'        => 'required|string|max:20|unique:tailors,phone,' . $tailor->id,
            'cnic'         => 'nullable|string|max:20',
            'address'      => 'nullable|string',
            'joining_date' => 'nullable|date',
            'status'       => 'nullable|in:active,on_leave',
            'specialty'    => 'nullable|in:shalwar_kameez,sherwani,all',
            'branch_id'    => 'nullable|exists:branches,id',
            'notes'        => 'nullable|string',
        ]);

        $tailor->update($validated);

        return redirect()->route('tailors.show', $tailor)
            ->with('success', 'Tailor updated successfully.');
    }

    public function toggleStatus(Tailor $tailor)
    {
        $tailor->status = $tailor->status === 'active' ? 'on_leave' : 'active';
        $tailor->save();

        return redirect()->back()
            ->with('success', "Tailor marked as {$tailor->status}.");
    }

    public function destroy(Tailor $tailor)
    {
        $activeOrders = $tailor->orders()
            ->whereHas('status', fn ($q) => $q->whereNotIn('name', ['Delivered', 'Cancelled']))
            ->count();

        if ($activeOrders > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete a tailor with active (non-delivered) orders.');
        }

        $tailor->delete();

        return redirect()->route('tailors.index')
            ->with('success', 'Tailor deleted successfully.');
    }
}
