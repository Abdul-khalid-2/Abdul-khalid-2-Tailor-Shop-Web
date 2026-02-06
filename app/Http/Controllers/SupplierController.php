<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        return view('dashboard.suppliers.index');
    }

    public function create()
    {
        return view('dashboard.suppliers.create');
    }

    public function store(Request $request)
    {
        // Store logic here
        return redirect()->route('suppliers.index')->with('success', 'Supplier created successfully.');
    }

    public function show($id)
    {
        return view('dashboard.suppliers.show');
    }

    public function edit($id)
    {
        return view('dashboard.suppliers.edit');
    }

    public function update(Request $request, $id)
    {
        // Update logic here
        return redirect()->route('suppliers.show', $id)->with('success', 'Supplier updated successfully.');
    }

    public function destroy($id)
    {
        // Delete logic here
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted successfully.');
    }
}
