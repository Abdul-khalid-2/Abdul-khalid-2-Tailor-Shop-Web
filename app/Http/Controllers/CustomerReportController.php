<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerReportController extends Controller
{
    public function index()
    {
        return view('dashboard.reports.customers.index');
    }

    public function sales()
    {
        return view('dashboard.reports.customers.sales');
    }

    public function loyalty()
    {
        return view('dashboard.reports.customers.loyalty');
    }
}
