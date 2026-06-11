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
        $branches = $this->isSuperAdmin()
            ? Branch::where('is_active', true)->orderBy('name')->get()
            : collect();

        return view('dashboard.tailors.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:150',
            'phone'         => ['required', 'string', 'max:20', $this->branchScopedUnique('tailors', 'phone')],
            'cnic'          => 'nullable|string|max:20',
            'address'       => 'nullable|string',
            'joining_date'  => 'nullable|date',
            'status'        => 'nullable|in:active,on_leave',
            'specialty'     => 'nullable|in:shalwar_kameez,sherwani,all',
            'branch_id'     => 'nullable|exists:branches,id',
            'notes'         => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated = $this->enforceBranchId($validated);

        $data = collect($validated)->except('profile_photo')->all();
        $data['status'] = $data['status'] ?? 'active';
        $data['specialty'] = $data['specialty'] ?? 'all';

        $tailor = Tailor::create($data);

        if ($request->hasFile('profile_photo')) {
            $tailor->update([
                'profile_photo' => $this->storeBranchImage(
                    $request->file('profile_photo'), 'tailor_images', $tailor->branch_id
                ),
            ]);
        }

        return redirect()->route('tailors.show', $tailor)
            ->with('success', __('messages.tailor_created'));
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
        $branches = $this->isSuperAdmin()
            ? Branch::where('is_active', true)->orderBy('name')->get()
            : collect();

        return view('dashboard.tailors.edit', compact('tailor', 'branches'));
    }

    public function update(Request $request, Tailor $tailor)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:150',
            'phone'         => ['required', 'string', 'max:20', $this->branchScopedUnique('tailors', 'phone', $tailor->id)],
            'cnic'          => 'nullable|string|max:20',
            'address'       => 'nullable|string',
            'joining_date'  => 'nullable|date',
            'status'        => 'nullable|in:active,on_leave',
            'specialty'     => 'nullable|in:shalwar_kameez,sherwani,all',
            'branch_id'     => 'nullable|exists:branches,id',
            'notes'         => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated = $this->enforceBranchId($validated);

        $data = collect($validated)->except('profile_photo')->all();

        $tailor->update($data);

        if ($request->hasFile('profile_photo')) {
            $tailor->update([
                'profile_photo' => $this->storeBranchImage(
                    $request->file('profile_photo'), 'tailor_images', $tailor->branch_id, $tailor->profile_photo
                ),
            ]);
        }

        return redirect()->route('tailors.show', $tailor)
            ->with('success', __('messages.tailor_updated'));
    }

    public function toggleStatus(Tailor $tailor)
    {
        $tailor->status = $tailor->status === 'active' ? 'on_leave' : 'active';
        $tailor->save();

        return redirect()->back()
            ->with('success', __('messages.tailor_marked', [
                'status' => $tailor->status === 'active' ? __('messages.active') : __('messages.on_leave'),
            ]));
    }

    public function destroy(Tailor $tailor)
    {
        $activeOrders = $tailor->orders()
            ->whereHas('status', fn ($q) => $q->whereNotIn('name', ['Delivered', 'Cancelled']))
            ->count();

        if ($activeOrders > 0) {
            return redirect()->back()
                ->with('error', __('messages.tailor_has_active_orders'));
        }

        $this->deleteBranchImage($tailor->profile_photo);

        $tailor->delete();

        return redirect()->route('tailors.index')
            ->with('success', __('messages.tailor_deleted'));
    }
}
