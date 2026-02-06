<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $branches = Branch::with('setting')->get();
        return view('dashboard.settings.index', compact('branches'));
    }

    public function general()
    {
        // Get main settings (branch_id = null or main branch)
        $setting = Setting::whereNull('branch_id')
            ->orWhereHas('branch', function ($q) {
                $q->where('code', 'main');
            })
            ->first();

        if (!$setting) {
            // Create default main settings
            $setting = Setting::create([
                'shop_name' => 'Tailor Shop',
                'shop_phone' => '+92 300 1234567',
                'shop_email' => 'info@tailorshop.com',
                'shop_address' => 'Main Street, City',
                'currency' => 'PKR',
                'currency_symbol' => 'Rs',
                'default_delivery_days' => 7,
                'tax_rate' => 0,
                'receipt_header' => 'Thank you for your business!',
                'receipt_footer' => 'Visit us again!',
                'receipt_prefix' => 'TS',
                'next_receipt_number' => 1000,
                'sms_notifications' => true,
                'email_notifications' => true,
                'reminder_days_before' => 1,
                'created_by' => auth()->id(),
            ]);
        }

        return view('dashboard.settings.general', compact('setting'));
    }

    public function updateGeneral(Request $request)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_phone' => 'required|string|max:20',
            'shop_email' => 'nullable|email|max:255',
            'shop_address' => 'nullable|string',
            'currency' => 'required|string|size:3',
            'currency_symbol' => 'required|string|max:10',
            'default_delivery_days' => 'required|integer|min:1|max:30',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'receipt_header' => 'nullable|string',
            'receipt_footer' => 'nullable|string',
            'receipt_prefix' => 'required|string|max:10',
            'next_receipt_number' => 'required|integer|min:1',
            'sms_notifications' => 'boolean',
            'email_notifications' => 'boolean',
            'reminder_days_before' => 'integer|min:0|max:7',
        ]);

        $setting = Setting::whereNull('branch_id')
            ->orWhereHas('branch', function ($q) {
                $q->where('code', 'main');
            })
            ->first();

        if ($setting) {
            $setting->update([
                'shop_name' => $request->shop_name,
                'shop_phone' => $request->shop_phone,
                'shop_email' => $request->shop_email,
                'shop_address' => $request->shop_address,
                'currency' => $request->currency,
                'currency_symbol' => $request->currency_symbol,
                'default_delivery_days' => $request->default_delivery_days,
                'tax_rate' => $request->tax_rate,
                'receipt_header' => $request->receipt_header,
                'receipt_footer' => $request->receipt_footer,
                'receipt_prefix' => $request->receipt_prefix,
                'next_receipt_number' => $request->next_receipt_number,
                'sms_notifications' => $request->has('sms_notifications'),
                'email_notifications' => $request->has('email_notifications'),
                'reminder_days_before' => $request->reminder_days_before,
                'updated_by' => auth()->id(),
            ]);
        }

        return redirect()->route('settings.general')
            ->with('success', 'General settings updated successfully.');
    }

    public function branch(Branch $branch)
    {
        $setting = $branch->setting;

        if (!$setting) {
            // Create default settings for branch
            $setting = Setting::create([
                'branch_id' => $branch->id,
                'shop_name' => $branch->name,
                'shop_phone' => $branch->phone,
                'shop_email' => $branch->email,
                'shop_address' => $branch->address,
                'currency' => 'PKR',
                'currency_symbol' => 'Rs',
                'default_delivery_days' => 7,
                'tax_rate' => 0,
                'receipt_prefix' => strtoupper(substr($branch->code, 0, 2)),
                'next_receipt_number' => 1000,
                'sms_notifications' => true,
                'email_notifications' => true,
                'reminder_days_before' => 1,
                'created_by' => auth()->id(),
            ]);
        }

        return view('dashboard.settings.branch', compact('branch', 'setting'));
    }

    public function updateBranch(Request $request, Branch $branch)
    {
        $request->validate([
            'shop_name' => 'required|string|max:255',
            'shop_phone' => 'required|string|max:20',
            'shop_email' => 'nullable|email|max:255',
            'shop_address' => 'nullable|string',
            'currency' => 'required|string|size:3',
            'currency_symbol' => 'required|string|max:10',
            'default_delivery_days' => 'required|integer|min:1|max:30',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'receipt_header' => 'nullable|string',
            'receipt_footer' => 'nullable|string',
            'receipt_prefix' => 'required|string|max:10',
            'next_receipt_number' => 'required|integer|min:1',
            'sms_notifications' => 'boolean',
            'email_notifications' => 'boolean',
            'reminder_days_before' => 'integer|min:0|max:7',
        ]);

        $setting = $branch->setting;

        if ($setting) {
            $setting->update([
                'shop_name' => $request->shop_name,
                'shop_phone' => $request->shop_phone,
                'shop_email' => $request->shop_email,
                'shop_address' => $request->shop_address,
                'currency' => $request->currency,
                'currency_symbol' => $request->currency_symbol,
                'default_delivery_days' => $request->default_delivery_days,
                'tax_rate' => $request->tax_rate,
                'receipt_header' => $request->receipt_header,
                'receipt_footer' => $request->receipt_footer,
                'receipt_prefix' => $request->receipt_prefix,
                'next_receipt_number' => $request->next_receipt_number,
                'sms_notifications' => $request->has('sms_notifications'),
                'email_notifications' => $request->has('email_notifications'),
                'reminder_days_before' => $request->reminder_days_before,
                'updated_by' => auth()->id(),
            ]);
        }

        return redirect()->route('settings.branch', $branch)
            ->with('success', 'Branch settings updated successfully.');
    }

    public function update(Request $request)
    {
        // This handles multiple setting updates
        $settings = $request->except('_token', '_method');

        foreach ($settings as $key => $value) {
            // Store in session or database as needed
            // For now, we'll use config
            config(["settings.{$key}" => $value]);
        }

        return redirect()->route('settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
