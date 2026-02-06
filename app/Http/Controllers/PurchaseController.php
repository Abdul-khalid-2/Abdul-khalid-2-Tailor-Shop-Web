<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        return view('dashboard.purchases.index');
    }

    public function create()
    {
        return view('dashboard.purchases.create');
    }

    public function store(Request $request)
    {
        // Store logic here
        return redirect()->route('purchases.index')->with('success', 'Purchase order created successfully.');
    }

    public function show($id)
    {
        return view('dashboard.purchases.show');
    }

    public function edit($id)
    {
        return view('dashboard.purchases.edit');
    }

    public function update(Request $request, $id)
    {
        // Update logic here
        return redirect()->route('purchases.show', $id)->with('success', 'Purchase order updated successfully.');
    }

    public function destroy($id)
    {
        // Delete logic here
        return redirect()->route('purchases.index')->with('success', 'Purchase order deleted successfully.');
    }
}
