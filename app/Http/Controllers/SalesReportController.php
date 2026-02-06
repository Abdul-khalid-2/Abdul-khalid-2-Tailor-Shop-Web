<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesReportController extends Controller
{
    public function index()
    {
        return view('dashboard.reports.sales.index');
    }

    public function daily()
    {
        return view('dashboard.reports.sales.daily');
    }

    public function product()
    {
        return view('dashboard.reports.sales.product');
    }
}
