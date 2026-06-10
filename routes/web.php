<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TailorController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::get('languages/{locale}', function ($locale) {
    if (array_key_exists($locale, config('laravellocalization.supportedLocales'))) {
        session(['locale' => $locale]);
    }

    return redirect(
        LaravelLocalization::getLocalizedURL($locale, url()->previous())
    );
})->name('lang.switch');

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [
        'Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect',
        'Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter',
        'Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath',
    ],
], function () {

    Route::get('/', function () {
        return view('welcome');
    });

    // Profile
    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    /*
    |--------------------------------------------------------------------------
    | Application routes (auth + verified)
    |--------------------------------------------------------------------------
    */
    Route::middleware(['auth', 'verified', 'role:superadmin|admin'])->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Customers
        Route::prefix('customers')->name('customers.')->group(function () {
            Route::get('/', [CustomerController::class, 'index'])->name('index');
            Route::get('/create', [CustomerController::class, 'create'])->name('create');
            Route::post('/', [CustomerController::class, 'store'])->name('store');
            Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
            Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('edit');
            Route::put('/{customer}', [CustomerController::class, 'update'])->name('update');
            Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
        });

        // Orders
        Route::prefix('orders')->name('orders.')->group(function () {
            // Status views — must be declared before the /{order} wildcard
            Route::get('/pending', [OrderController::class, 'pending'])->name('pending');
            Route::get('/in-progress', [OrderController::class, 'inProgress'])->name('in-progress');
            Route::get('/ready', [OrderController::class, 'ready'])->name('ready');
            Route::get('/overdue', [OrderController::class, 'overdue'])->name('overdue');

            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/create', [OrderController::class, 'create'])->name('create');
            Route::post('/', [OrderController::class, 'store'])->name('store');
            Route::get('/{order}', [OrderController::class, 'show'])->name('show');
            Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit');
            Route::put('/{order}', [OrderController::class, 'update'])->name('update');
            Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');

            // Status + payments
            Route::patch('/{order}/status', [OrderController::class, 'updateStatus'])->name('update-status');
            Route::post('/{order}/tailor-payment', [OrderController::class, 'recordTailorPayment'])->name('tailor-payment');
            Route::post('/{order}/customer-payment', [OrderController::class, 'recordCustomerPayment'])->name('customer-payment');
        });

        // Tailors
        Route::prefix('tailors')->name('tailors.')->group(function () {
            Route::get('/', [TailorController::class, 'index'])->name('index');
            Route::get('/create', [TailorController::class, 'create'])->name('create');
            Route::post('/', [TailorController::class, 'store'])->name('store');
            Route::get('/{tailor}', [TailorController::class, 'show'])->name('show');
            Route::get('/{tailor}/edit', [TailorController::class, 'edit'])->name('edit');
            Route::put('/{tailor}', [TailorController::class, 'update'])->name('update');
            Route::patch('/{tailor}/toggle', [TailorController::class, 'toggleStatus'])->name('toggle');
            Route::delete('/{tailor}', [TailorController::class, 'destroy'])->name('destroy');
        });

        // Branches (Super Admin — via Settings menu)
        Route::prefix('dashboard/branches')->name('branches.')->middleware('role:superadmin')->group(function () {
            Route::get('/', [BranchController::class, 'index'])->name('index');
            Route::get('/create', [BranchController::class, 'create'])->name('create');
            Route::post('/', [BranchController::class, 'store'])->name('store');
            Route::get('/{branch}', [BranchController::class, 'show'])->name('show');
            Route::get('/{branch}/edit', [BranchController::class, 'edit'])->name('edit');
            Route::put('/{branch}', [BranchController::class, 'update'])->name('update');
            Route::delete('/{branch}', [BranchController::class, 'destroy'])->name('destroy');
            Route::post('/{branch}/toggle-status', [BranchController::class, 'toggleStatus'])->name('toggle-status');
        });

        // Settings
        Route::prefix('dashboard/settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');

            Route::get('/general', [SettingController::class, 'general'])->name('general');
            Route::put('/general', [SettingController::class, 'updateGeneral'])->name('update.general');
            Route::get('/logo/delete/{type}/{branch?}', [SettingController::class, 'deleteLogo'])->name('delete.logo');

            // Per-branch shop settings (linked from Branches module)
            Route::get('/branch/{branch}', [SettingController::class, 'branch'])->name('branch');
            Route::put('/branch/{branch}', [SettingController::class, 'updateBranch'])->name('update.branch');
            Route::post('/branch/{branch}/reset', [SettingController::class, 'resetToGeneral'])->name('reset.to.general');

            // Users (Super Admin only)
            Route::prefix('users')->name('users.')->middleware('role:superadmin')->group(function () {
                Route::get('/', [SettingController::class, 'usersIndex'])->name('index');
                Route::get('/create', [SettingController::class, 'usersCreate'])->name('create');
                Route::post('/', [SettingController::class, 'usersStore'])->name('store');
                Route::get('/{user}/edit', [SettingController::class, 'usersEdit'])->name('edit');
                Route::put('/{user}', [SettingController::class, 'usersUpdate'])->name('update');
                Route::delete('/{user}', [SettingController::class, 'usersDestroy'])->name('destroy');
            });

            // Order statuses (Super Admin only)
            Route::middleware('role:superadmin')->group(function () {
                Route::get('/order-statuses', [SettingController::class, 'orderStatusesIndex'])->name('order-statuses.index');
                Route::put('/order-statuses/{orderStatus}', [SettingController::class, 'orderStatusUpdate'])->name('order-statuses.update');
            });
        });
    });
});

require __DIR__ . '/auth.php';
