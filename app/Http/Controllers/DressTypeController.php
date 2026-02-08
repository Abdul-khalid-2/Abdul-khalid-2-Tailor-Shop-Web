<?php

namespace App\Http\Controllers;

use App\Models\DressType;
use App\Models\Branch;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DressTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = DressType::with(['createdBy', 'updatedBy'])
            ->withCount(['orderItems as monthly_orders' => function ($query) {
                $query->whereHas('order', function ($q) {
                    $q->whereMonth('order_date', Carbon::now()->month)
                        ->whereYear('order_date', Carbon::now()->year);
                });
            }])
            ->withCount(['orderItems as total_orders']);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('is_active', $request->status == 'active');
        }

        // Sort
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $dressTypes = $query->paginate(20);

        // Get statistics
        $stats = $this->getStats();

        return view('dashboard.dress-types.index', compact('dressTypes', 'stats'));
    }

    /**
     * Get dress type statistics
     */
    private function getStats()
    {
        $stats = [
            'total' => DressType::count(),
            'active' => DressType::where('is_active', true)->count(),
            'inactive' => DressType::where('is_active', false)->count(),
            'avg_price' => DressType::where('is_active', true)->avg('base_price') ?? 0,
            'min_price' => DressType::where('is_active', true)->min('base_price') ?? 0,
            'max_price' => DressType::where('is_active', true)->max('base_price') ?? 0,
            'avg_days' => DressType::where('is_active', true)->avg('estimated_days') ?? 0,
        ];

        // Get most popular dress type this month
        $popular = OrderItem::select('dress_type_id', DB::raw('COUNT(*) as order_count'))
            ->whereHas('order', function ($q) {
                $q->whereMonth('order_date', Carbon::now()->month)
                    ->whereYear('order_date', Carbon::now()->year);
            })
            ->whereNotNull('dress_type_id')
            ->groupBy('dress_type_id')
            ->orderBy('order_count', 'desc')
            ->first();

        if ($popular && $popular->dressType) {
            $stats['most_popular'] = [
                'name' => $popular->dressType->name,
                'orders' => $popular->order_count
            ];
        } else {
            $stats['most_popular'] = [
                'name' => 'N/A',
                'orders' => 0
            ];
        }

        return $stats;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.dress-types.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:dress_types',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1|max:365',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        DressType::create($validated);

        return redirect()->route('dress-types.index')
            ->with('success', 'Dress type created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DressType $dressType)
    {
        return view('dashboard.dress-types.edit', compact('dressType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DressType $dressType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:dress_types,name,' . $dressType->id,
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'estimated_days' => 'required|integer|min:1|max:365',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['updated_by'] = Auth::id();

        $dressType->update($validated);

        return redirect()->route('dress-types.index')
            ->with('success', 'Dress type updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DressType $dressType)
    {
        // Check if dress type has any orders
        if ($dressType->orderItems()->exists()) {
            return redirect()->route('dress-types.index')
                ->with('error', 'Cannot delete dress type. It has associated orders.');
        }

        $dressType->delete();

        return redirect()->route('dress-types.index')
            ->with('success', 'Dress type deleted successfully.');
    }

    /**
     * Toggle dress type status
     */
    public function toggleStatus(DressType $dressType)
    {
        $dressType->update([
            'is_active' => !$dressType->is_active,
            'updated_by' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'is_active' => $dressType->is_active,
            'message' => 'Status updated successfully'
        ]);
    }

    /**
     * Export dress types
     */
    public function export()
    {
        $dressTypes = DressType::with(['createdBy', 'updatedBy'])
            ->withCount(['orderItems as total_orders'])
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="dress_types_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($dressTypes) {
            $file = fopen('php://output', 'w');

            // Headers
            fputcsv($file, [
                'ID',
                'Name',
                'Slug',
                'Description',
                'Base Price',
                'Estimated Days',
                'Total Orders',
                'Status',
                'Created By',
                'Updated At'
            ]);

            // Data
            foreach ($dressTypes as $dressType) {
                fputcsv($file, [
                    $dressType->id,
                    $dressType->name,
                    $dressType->slug,
                    $dressType->description,
                    $dressType->base_price,
                    $dressType->estimated_days,
                    $dressType->total_orders,
                    $dressType->is_active ? 'Active' : 'Inactive',
                    $dressType->createdBy->name ?? 'N/A',
                    $dressType->updated_at->format('Y-m-d H:i:s')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import dress types
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        // Handle import logic here
        // You can use Laravel Excel package or custom CSV parsing

        return redirect()->route('dress-types.index')
            ->with('success', 'Dress types imported successfully.');
    }

    /**
     * Get dress types statistics API
     */
    public function stats()
    {
        $stats = $this->getStats();

        return response()->json($stats);
    }

    /**
     * Get dress type popularity data for chart
     */
    public function popularityChart()
    {
        $popularity = OrderItem::select('dress_type_id', DB::raw('COUNT(*) as order_count'))
            ->whereHas('order', function ($q) {
                $q->whereMonth('order_date', Carbon::now()->month)
                    ->whereYear('order_date', Carbon::now()->year);
            })
            ->whereNotNull('dress_type_id')
            ->groupBy('dress_type_id')
            ->with('dressType')
            ->orderBy('order_count', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->dressType->name,
                    'orders' => $item->order_count
                ];
            });

        return response()->json($popularity);
    }
}
