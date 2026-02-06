<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LedgerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.accounts.ledger.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function trialBalance()
    {
        return view('dashboard.accounts.ledger.trial-balance');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function accountLedger(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
