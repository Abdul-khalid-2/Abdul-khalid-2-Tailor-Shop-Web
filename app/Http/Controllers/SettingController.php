<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\OrderStatus;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class SettingController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Settings menu
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $this->authorizeSettingsAccess();

        return view('dashboard.settings.index', [
            'isSuperAdmin' => $this->isSuperAdmin(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | General settings (Super Admin = global, Branch Admin = own branch)
    |--------------------------------------------------------------------------
    */
    public function general()
    {
        $this->authorizeSettingsAccess();

        [$setting, $scope, $branch] = $this->resolveGeneralSetting();

        return view('dashboard.settings.general', compact('setting', 'scope', 'branch'));
    }

    public function updateGeneral(Request $request)
    {
        $this->authorizeSettingsAccess();

        [$setting, $scope] = $this->resolveGeneralSetting();

        $validated = $request->validate([
            'shop_name'             => 'required|string|max:255',
            'shop_phone'            => 'required|string|max:20',
            'shop_email'            => 'nullable|email|max:255',
            'shop_address'          => 'nullable|string',
            'currency'              => 'required|string|max:3',
            'currency_symbol'       => 'required|string|max:10',
            'default_delivery_days' => 'required|integer|min:1|max:30',
            'tax_rate'              => 'required|numeric|min:0|max:100',
            'receipt_header'        => 'nullable|string',
            'receipt_footer'        => 'nullable|string',
            'receipt_prefix'        => 'required|string|max:10',
            'next_receipt_number'   => 'required|integer|min:1',
            'reminder_days_before'    => 'nullable|integer|min:0|max:7',
            'logo'                  => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        $data = collect($validated)->except('logo')->all();
        $data['sms_notifications']   = $request->has('sms_notifications');
        $data['email_notifications'] = $request->has('email_notifications');
        if ($request->hasFile('logo')) {
            if ($setting->logo_path) {
                Storage::disk('public')->delete($setting->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('settings/logos', 'public');
        }

        if (! $setting->exists && $scope === 'branch') {
            $data['branch_id'] = auth()->user()->branch_id;
        }

        $setting->fill($data);
        $setting->save();

        return redirect()->route('settings.general')
            ->with('success', 'General settings updated successfully.');
    }

    public function deleteLogo($type = 'general', Branch $branch = null)
    {
        $this->authorizeSettingsAccess();

        if ($type === 'branch' && $branch) {
            $this->authorizeSuperAdmin();
            $setting = $branch->setting;
        } else {
            [$setting] = $this->resolveGeneralSetting();
        }

        if ($setting?->logo_path) {
            Storage::disk('public')->delete($setting->logo_path);
            $setting->update(['logo_path' => null]);
        }

        return redirect()->back()->with('success', 'Logo deleted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Per-branch settings (Super Admin only — linked from Branches module)
    |--------------------------------------------------------------------------
    */
    public function branch(Branch $branch)
    {
        $this->authorizeSuperAdmin();

        $setting = $branch->setting ?? $this->createBranchSettings($branch);

        return view('dashboard.settings.branch', compact('branch', 'setting'));
    }

    public function updateBranch(Request $request, Branch $branch)
    {
        $this->authorizeSuperAdmin();

        $validated = $request->validate([
            'shop_name'             => 'required|string|max:255',
            'shop_phone'            => 'required|string|max:20',
            'shop_email'            => 'nullable|email|max:255',
            'shop_address'          => 'nullable|string',
            'currency'              => 'required|string|max:3',
            'currency_symbol'       => 'required|string|max:10',
            'default_delivery_days' => 'required|integer|min:1|max:30',
            'tax_rate'              => 'required|numeric|min:0|max:100',
            'receipt_header'        => 'nullable|string',
            'receipt_footer'        => 'nullable|string',
            'receipt_prefix'        => 'required|string|max:10',
            'next_receipt_number'   => 'required|integer|min:1',
            'reminder_days_before'  => 'nullable|integer|min:0|max:7',
            'logo'                  => 'nullable|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        $setting = $branch->setting ?? new Setting(['branch_id' => $branch->id]);

        $data = collect($validated)->except('logo')->all();
        $data['sms_notifications']   = $request->has('sms_notifications');
        $data['email_notifications'] = $request->has('email_notifications');
        if ($request->hasFile('logo')) {
            if ($setting->logo_path) {
                Storage::disk('public')->delete($setting->logo_path);
            }
            $data['logo_path'] = $request->file('logo')->store('settings/logos', 'public');
        }

        $setting->fill($data);
        $setting->save();

        return redirect()->route('settings.branch', $branch)
            ->with('success', 'Branch settings updated successfully.');
    }

    public function resetToGeneral(Branch $branch)
    {
        $this->authorizeSuperAdmin();

        $general = Setting::whereNull('branch_id')->first();
        $branchSettings = $branch->setting;

        if ($general && $branchSettings) {
            $branchSettings->update([
                'shop_name'             => $general->shop_name,
                'shop_phone'            => $general->shop_phone,
                'shop_email'            => $general->shop_email,
                'shop_address'          => $general->shop_address,
                'currency'              => $general->currency,
                'currency_symbol'       => $general->currency_symbol,
                'default_delivery_days' => $general->default_delivery_days,
                'tax_rate'              => $general->tax_rate,
                'receipt_header'        => $general->receipt_header,
                'receipt_footer'        => $general->receipt_footer,
                'receipt_prefix'        => $general->receipt_prefix,
                'sms_notifications'     => $general->sms_notifications,
                'email_notifications'   => $general->email_notifications,
                'reminder_days_before'  => $general->reminder_days_before,
            ]);
        }

        return redirect()->back()->with('success', 'Branch settings reset to general defaults.');
    }

    /*
    |--------------------------------------------------------------------------
    | Users (Super Admin only)
    |--------------------------------------------------------------------------
    */
    public function usersIndex()
    {
        $this->authorizeSuperAdmin();

        $users = User::with(['branch', 'roles'])
            ->latest()
            ->paginate(20);

        return view('dashboard.settings.users.index', compact('users'));
    }

    public function usersCreate()
    {
        $this->authorizeSuperAdmin();

        $branches = Branch::where('is_active', true)->orderBy('name')->get();
        $roles    = Role::whereIn('name', ['superadmin', 'admin'])->orderBy('name')->get();

        return view('dashboard.settings.users.create', compact('branches', 'roles'));
    }

    public function usersStore(Request $request)
    {
        $this->authorizeSuperAdmin();

        $validated = $request->validate([
            'name'      => 'required|string|max:150',
            'email'     => 'required|email|max:255|unique:users,email',
            'phone'     => 'nullable|string|max:20',
            'password'  => ['required', 'confirmed', Password::defaults()],
            'status'    => 'required|in:active,inactive,suspended',
            'role'      => 'required|in:superadmin,admin',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        $user = User::create([
            'name'              => $validated['name'],
            'email'             => $validated['email'],
            'phone'             => $validated['phone'] ?? null,
            'password'          => Hash::make($validated['password']),
            'status'            => $validated['status'],
            'branch_id'         => $validated['branch_id'] ?? null,
            'email_verified_at' => now(),
        ]);

        $user->syncRoles([$validated['role']]);

        return redirect()->route('settings.users.index')
            ->with('success', 'User created successfully.');
    }

    public function usersEdit(User $user)
    {
        $this->authorizeSuperAdmin();

        $branches = Branch::where('is_active', true)->orderBy('name')->get();
        $roles    = Role::whereIn('name', ['superadmin', 'admin'])->orderBy('name')->get();

        return view('dashboard.settings.users.edit', compact('user', 'branches', 'roles'));
    }

    public function usersUpdate(Request $request, User $user)
    {
        $this->authorizeSuperAdmin();

        $validated = $request->validate([
            'name'      => 'required|string|max:150',
            'email'     => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone'     => 'nullable|string|max:20',
            'password'  => ['nullable', 'confirmed', Password::defaults()],
            'status'    => 'required|in:active,inactive,suspended',
            'role'      => 'required|in:superadmin,admin',
            'branch_id' => 'nullable|exists:branches,id',
        ]);

        $user->update([
            'name'      => $validated['name'],
            'email'     => $validated['email'],
            'phone'     => $validated['phone'] ?? null,
            'status'    => $validated['status'],
            'branch_id' => $validated['branch_id'] ?? null,
        ]);

        if (! empty($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        $user->syncRoles([$validated['role']]);

        return redirect()->route('settings.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function usersDestroy(User $user)
    {
        $this->authorizeSuperAdmin();

        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('settings.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Order statuses (Super Admin only)
    |--------------------------------------------------------------------------
    */
    public function orderStatusesIndex()
    {
        $this->authorizeSuperAdmin();

        $statuses = OrderStatus::orderBy('sort_order')->get();

        return view('dashboard.settings.order-statuses.index', compact('statuses'));
    }

    public function orderStatusUpdate(Request $request, OrderStatus $orderStatus)
    {
        $this->authorizeSuperAdmin();

        $validated = $request->validate([
            'name'       => 'required|string|max:100',
            'color'      => 'required|string|max:20',
            'sort_order' => 'required|integer|min:0',
            'is_active'  => 'boolean',
        ]);

        $orderStatus->update([
            'name'       => $validated['name'],
            'color'      => $validated['color'],
            'sort_order' => $validated['sort_order'],
            'is_active'  => $request->has('is_active'),
        ]);

        return redirect()->route('settings.order-statuses.index')
            ->with('success', "Status \"{$orderStatus->name}\" updated.");
    }

    /*
    |--------------------------------------------------------------------------
    | Authorization helpers
    |--------------------------------------------------------------------------
    */
    private function isBranchAdmin(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    private function authorizeSettingsAccess(): void
    {
        if (! $this->isSuperAdmin() && ! $this->isBranchAdmin()) {
            abort(403, 'You do not have access to settings.');
        }
    }

    /**
     * @return array{0: Setting, 1: string, 2: ?Branch}
     */
    private function resolveGeneralSetting(): array
    {
        if ($this->isSuperAdmin()) {
            $setting = Setting::whereNull('branch_id')->first() ?? $this->createDefaultSettings();

            return [$setting, 'global', null];
        }

        $branch = auth()->user()->branch;

        if (! $branch) {
            abort(403, 'No branch assigned to your account. Contact Super Admin.');
        }

        $setting = $branch->setting ?? $this->createBranchSettings($branch);

        return [$setting, 'branch', $branch];
    }

    private function createDefaultSettings(): Setting
    {
        return Setting::create([
            'shop_name'             => 'Tailor Shop',
            'shop_phone'            => '+92 300 1234567',
            'shop_email'            => null,
            'shop_address'          => null,
            'currency'              => 'PKR',
            'currency_symbol'       => 'Rs',
            'default_delivery_days' => 7,
            'tax_rate'              => 0,
            'receipt_header'        => 'Thank you for your business!',
            'receipt_footer'        => 'Visit us again soon!',
            'receipt_prefix'        => 'ORD',
            'next_receipt_number'   => 1000,
            'sms_notifications'     => false,
            'email_notifications'   => false,
            'reminder_days_before'  => 1,
        ]);
    }

    private function createBranchSettings(Branch $branch): Setting
    {
        $general = Setting::whereNull('branch_id')->first();

        if ($general) {
            return Setting::create([
                'branch_id'             => $branch->id,
                'shop_name'             => $branch->name,
                'shop_phone'            => $branch->phone ?? $general->shop_phone,
                'shop_email'            => $branch->email ?? $general->shop_email,
                'shop_address'          => $branch->address ?? $general->shop_address,
                'currency'              => $general->currency,
                'currency_symbol'       => $general->currency_symbol,
                'default_delivery_days' => $general->default_delivery_days,
                'tax_rate'              => $general->tax_rate,
                'receipt_header'        => $general->receipt_header,
                'receipt_footer'        => $general->receipt_footer,
                'receipt_prefix'        => $general->receipt_prefix,
                'next_receipt_number'   => $general->next_receipt_number,
                'sms_notifications'     => $general->sms_notifications,
                'email_notifications'   => $general->email_notifications,
                'reminder_days_before'  => $general->reminder_days_before,
            ]);
        }

        $this->createDefaultSettings();

        return Setting::create([
            'branch_id'             => $branch->id,
            'shop_name'             => $branch->name,
            'shop_phone'            => $branch->phone ?? '+92 300 1234567',
            'shop_email'            => $branch->email,
            'shop_address'          => $branch->address,
            'currency'              => 'PKR',
            'currency_symbol'       => 'Rs',
            'default_delivery_days' => 7,
            'tax_rate'              => 0,
            'receipt_prefix'        => 'ORD',
            'next_receipt_number'   => 1000,
            'sms_notifications'     => false,
            'email_notifications'   => false,
            'reminder_days_before'  => 1,
        ]);
    }
}
