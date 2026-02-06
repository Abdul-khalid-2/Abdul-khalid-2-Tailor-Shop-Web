<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StockAdjustmentController extends Controller
{
    public function index()
    {
        return view('dashboard.inventory.adjustments.index');
    }

    /**
     * Show form to create new stock adjustment
     */
    public function create()
    {
        return view('dashboard.inventory.adjustments.create');
    }

    /**
     * Display specific stock adjustment
     */
    public function show($id)
    {
        return view('dashboard.inventory.adjustments.show');
    }

    /**
     * Show form to edit stock adjustment
     */
    public function edit($id)
    {
        return view('dashboard.inventory.adjustments.edit');
    }
}
