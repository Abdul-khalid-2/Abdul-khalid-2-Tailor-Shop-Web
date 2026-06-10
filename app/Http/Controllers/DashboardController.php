<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $pendingCount    = Order::pending()->count();
        $inProgressCount = Order::inProgress()->count();
        $readyCount      = Order::ready()->count();
        $overdueCount    = Order::overdue()->count();

        $overdueList = Order::overdue()
            ->with(['customer', 'tailor'])
            ->orderBy('delivery_date')
            ->take(10)
            ->get();

        $todayDeliveries = Order::whereDate('delivery_date', today())
            ->with('customer')
            ->whereHas('status', fn ($q) => $q->whereNotIn('name', ['Delivered', 'Cancelled']))
            ->orderBy('order_number')
            ->get();

        $recentOrders = Order::with(['customer', 'status'])
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.dashboard', compact(
            'pendingCount',
            'inProgressCount',
            'readyCount',
            'overdueCount',
            'overdueList',
            'todayDeliveries',
            'recentOrders'
        ));
    }
}
