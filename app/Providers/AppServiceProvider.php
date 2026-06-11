<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Make shop branding (name, logo, favicon) available to every view so the
        // app title/sidebar/navbar/auth/landing pages reflect the active Settings.
        View::composer('*', function ($view) {
            $setting = $this->activeSetting();

            $view->with([
                'brandName'    => $setting?->shop_name ?: config('app.name', 'Tailor Shop'),
                'brandLogo'    => $setting?->logo_url,
                'brandFavicon' => $setting?->favicon_url,
                'brandSetting' => $setting,
            ]);
        });
    }

    /**
     * Resolve the active shop Setting once per request (branch setting for a branch
     * admin, otherwise the global setting). Safe before the table exists (install/migrate).
     */
    protected function activeSetting(): ?Setting
    {
        static $resolved = false;
        static $setting = null;

        if ($resolved) {
            return $setting;
        }
        $resolved = true;

        try {
            if (! Schema::hasTable('settings')) {
                return $setting = null;
            }

            $branchId = auth()->user()?->branch_id;

            $setting = ($branchId ? Setting::where('branch_id', $branchId)->first() : null)
                ?? Setting::whereNull('branch_id')->first()
                ?? Setting::first();
        } catch (\Throwable $e) {
            $setting = null;
        }

        return $setting;
    }
}
