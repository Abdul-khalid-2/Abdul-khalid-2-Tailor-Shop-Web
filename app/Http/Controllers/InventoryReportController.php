<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InventoryReportController extends Controller
{
    public function index()
    {
        return view('dashboard.reports.inventory.index');
    }

    public function stockLevels()
    {
        return view('dashboard.reports.inventory.stock-levels');
    }

    public function movements()
    {
        return view('dashboard.reports.inventory.movements');
    }
}
