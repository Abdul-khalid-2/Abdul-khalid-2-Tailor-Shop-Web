<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.dashboard');
    }

    public function salesChart()
    {
        return view('dashboard.charts.sales-chart');
    }

    public function salesSummaryWidget()
    {
        return view('dashboard.widgets.sales-summary');
    }

    public function lowStockWidget()
    {
        return view('dashboard.widgets.low-stock');
    }

    public function topProductsWidget()
    {
        return view('dashboard.widgets.top-products');
    }

    public function inventoryChart()
    {
        return view('dashboard.charts.inventory-chart');
    }
}
