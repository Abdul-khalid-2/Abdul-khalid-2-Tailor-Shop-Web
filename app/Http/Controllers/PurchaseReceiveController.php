<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseReceiveController extends Controller
{
    public function create($purchaseId)
    {
        return view('dashboard.purchases.receive.create');
    }

    public function store(Request $request, $purchaseId)
    {
        // Store receiving logic here
        return redirect()->route('purchases.show', $purchaseId)->with('success', 'Goods received successfully.');
    }

    public function show($purchaseId, $receiveId)
    {
        return view('dashboard.purchases.receive.show');
    }
}
