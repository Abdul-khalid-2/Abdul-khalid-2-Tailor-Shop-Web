<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{
    public function index()
    {
        $branches = Branch::with('setting')->get();

        // Get main (global) settings
        $mainSettings = Setting::whereNull('branch_id')->first();

        return view('dashboard.settings.index', compact('branches', 'mainSettings'));
    }

    public function general()
    {
        $setting = Setting::whereNull('branch_id')->first();

        // If no main settings exist, create default
        if (!$setting) {
            $setting = $this->createDefaultSettings();
        }

        return view('dashboard.settings.general', compact('setting'));
    }

    public function updateGeneral(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shop_name' => 'required|string|max:255',
            'shop_phone' => 'required|string|max:20',
            'shop_email' => 'nullable|email|max:255',
            'shop_address' => 'nullable|string',
            'currency' => 'required|string|max:3',
            'currency_symbol' => 'required|string|max:10',
            'default_delivery_days' => 'required|integer|min:1|max:30',
            'tax_rate' => 'required|numeric|min:0|max:100',
            'receipt_header' => 'nullable|string',
            'receipt_footer' => 'nullable|string',
            'receipt_prefix' => 'required|string|max:10',
            'next_receipt_number' => 'required|integer|min:1',
            // Remove boolean validation for checkboxes
            // 'sms_notifications' => 'boolean',
            // 'email_notifications' => 'boolean',
            'reminder_days_before' => 'nullable|integer|min:0|max:7',
            'measurement_fields' => 'nullable|array',
            'measurement_fields.*' => 'string',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $setting = Setting::whereNull('branch_id')->first();

        if (!$setting) {
            $setting = new Setting();
            $setting->created_by = auth()->id();
        }

        $data = $request->except(['_token', '_method', 'logo']);
        $data['sms_notifications'] = $request->has('sms_notifications');
        $data['email_notifications'] = $request->has('email_notifications');
        $data['updated_by'] = auth()->id();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = $logo->store('settings/logos', 'public');
            $data['logo_path'] = $logoPath;

            // Delete old logo if exists
            if ($setting->logo_path) {
                Storage::disk('public')->delete($setting->logo_path);
            }
        }

        // Handle measurement fields
        if ($request->has('measurement_fields')) {
            $data['measurement_fields'] = $request->measurement_fields;
        } else {
            $data['measurement_fields'] = null; // or empty array []
        }

        $setting->fill($data);
        $setting->save();

        return redirect()->route('settings.general')
            ->with('success', 'General settings updated successfully!');
    }

    public function branch(Branch $branch)
    {
        $setting = $branch->setting;

        if (!$setting) {
            $setting = $this->createBranchSettings($branch);
        }

        return view('dashboard.settings.branch', compact('branch', 'setting'));
    }

    public function updateBranch(Request $request, Branch $branch)
    {

        $validator = Validator::make($request->all(), [
            'shop_name' => 'required|string|max:255',
            'shop_phone' => 'required|string|max:20',
            'shop_email' => 'nullable|email|max:255',
            'shop_address' => 'nullable|string',
            'currency' => 'required|string|max:3',
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
            'logo' => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $setting = $branch->setting;

        if (!$setting) {
            $setting = new Setting();
            $setting->branch_id = $branch->id;
            $setting->created_by = auth()->id();
        }

        $data = $request->except(['_token', '_method', 'logo']);
        $data['sms_notifications'] = $request->has('sms_notifications');
        $data['email_notifications'] = $request->has('email_notifications');
        $data['updated_by'] = auth()->id();

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoPath = $logo->store('settings/logos', 'public');
            $data['logo_path'] = $logoPath;

            // Delete old logo if exists
            if ($setting->logo_path) {
                Storage::disk('public')->delete($setting->logo_path);
            }
        }

        // Copy measurement fields from general settings if not set
        if (!$request->has('measurement_fields')) {
            $generalSettings = Setting::whereNull('branch_id')->first();
            if ($generalSettings) {
                $data['measurement_fields'] = $generalSettings->measurement_fields;
            }
        }

        $setting->fill($data);
        $setting->save();

        return redirect()->route('settings.branch', $branch)
            ->with('success', 'Branch settings updated successfully!');
    }

    // Lookup tables management
    public function lookups()
    {
        return view('dashboard.settings.lookups.index');
    }

    // Delete logo
    public function deleteLogo($type = 'general', Branch $branch = null)
    {
        if ($type === 'branch' && $branch) {
            $setting = $branch->setting;
            if ($setting && $setting->logo_path) {
                Storage::disk('public')->delete($setting->logo_path);
                $setting->logo_path = null;
                $setting->save();
            }
        } else {
            $setting = Setting::whereNull('branch_id')->first();
            if ($setting && $setting->logo_path) {
                Storage::disk('public')->delete($setting->logo_path);
                $setting->logo_path = null;
                $setting->save();
            }
        }

        return redirect()->back()
            ->with('success', 'Logo deleted successfully!');
    }

    // Reset branch settings to general
    public function resetToGeneral(Branch $branch)
    {
        $generalSettings = Setting::whereNull('branch_id')->first();
        $branchSettings = $branch->setting;

        if ($generalSettings && $branchSettings) {
            $branchSettings->update([
                'shop_name' => $generalSettings->shop_name,
                'shop_phone' => $generalSettings->shop_phone,
                'shop_email' => $generalSettings->shop_email,
                'shop_address' => $generalSettings->shop_address,
                'currency' => $generalSettings->currency,
                'currency_symbol' => $generalSettings->currency_symbol,
                'default_delivery_days' => $generalSettings->default_delivery_days,
                'tax_rate' => $generalSettings->tax_rate,
                'receipt_header' => $generalSettings->receipt_header,
                'receipt_footer' => $generalSettings->receipt_footer,
                'receipt_prefix' => $generalSettings->receipt_prefix,
                'measurement_fields' => $generalSettings->measurement_fields,
                'sms_notifications' => $generalSettings->sms_notifications,
                'email_notifications' => $generalSettings->email_notifications,
                'reminder_days_before' => $generalSettings->reminder_days_before,
                'updated_by' => auth()->id(),
            ]);
        }

        return redirect()->back()
            ->with('success', 'Branch settings reset to general settings!');
    }

    // Create default settings
    private function createDefaultSettings()
    {
        return Setting::create([
            'shop_name' => 'Tailor Shop Management System',
            'shop_phone' => '+92 300 1234567',
            'shop_email' => 'info@tailorshop.com',
            'shop_address' => 'Main Street, City, Country',
            'currency' => 'PKR',
            'currency_symbol' => 'Rs',
            'default_delivery_days' => 7,
            'tax_rate' => 0,
            'receipt_header' => 'Thank you for your business!',
            'receipt_footer' => 'Visit us again soon!',
            'receipt_prefix' => 'TS',
            'next_receipt_number' => 1000,
            'measurement_fields' => ['height', 'weight', 'chest', 'waist', 'hips', 'shoulder'],
            'sms_notifications' => true,
            'email_notifications' => true,
            'reminder_days_before' => 1,
            'created_by' => auth()->id(),
        ]);
    }

    // Create branch settings from template
    private function createBranchSettings(Branch $branch)
    {
        $generalSettings = Setting::whereNull('branch_id')->first();

        if ($generalSettings) {
            return Setting::create([
                'branch_id' => $branch->id,
                'shop_name' => $branch->name,
                'shop_phone' => $branch->phone ?? $generalSettings->shop_phone,
                'shop_email' => $branch->email ?? $generalSettings->shop_email,
                'shop_address' => $branch->address ?? $generalSettings->shop_address,
                'currency' => $generalSettings->currency,
                'currency_symbol' => $generalSettings->currency_symbol,
                'default_delivery_days' => $generalSettings->default_delivery_days,
                'tax_rate' => $generalSettings->tax_rate,
                'receipt_header' => $generalSettings->receipt_header,
                'receipt_footer' => $generalSettings->receipt_footer,
                'receipt_prefix' => strtoupper(substr($branch->code, 0, 2)) . '-BR',
                'next_receipt_number' => 1000,
                'measurement_fields' => $generalSettings->measurement_fields,
                'sms_notifications' => $generalSettings->sms_notifications,
                'email_notifications' => $generalSettings->email_notifications,
                'reminder_days_before' => $generalSettings->reminder_days_before,
                'created_by' => auth()->id(),
            ]);
        }

        return $this->createDefaultSettings();
    }

    // System backup
    public function backup()
    {
        // This would be implemented with backup package
        return view('dashboard.settings.backup');
    }

    // System information
    public function systemInfo()
    {
        $info = [
            'app_name' => config('app.name'),
            'app_version' => '1.0.0',
            'laravel_version' => app()->version(),
            'php_version' => phpversion(),
            'database' => config('database.default'),
            'timezone' => config('app.timezone'),
            'environment' => app()->environment(),
            'debug_mode' => config('app.debug'),
            'server' => $_SERVER['SERVER_SOFTWARE'] ?? 'N/A',
        ];

        return view('dashboard.settings.system-info', compact('info'));
    }
}
