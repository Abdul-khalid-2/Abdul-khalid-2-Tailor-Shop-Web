<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // This could be a reports dashboard or redirect to main sales report
        return view('dashboard.reports.index');
    }
}
