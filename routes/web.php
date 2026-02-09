<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\DressTypeController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Orders
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('dashboard/orders')->name('orders.')->group(function () {


        // Status-based routes (these should be before the show route)
        Route::get('/pending', [OrderController::class, 'pending'])->name('pending');
        Route::get('/in-progress', [OrderController::class, 'inProgress'])->name('in-progress');
        Route::get('/completed', [OrderController::class, 'completed'])->name('completed');
        Route::post('/customer/store', [OrderController::class, 'customerStore'])->name('customer.store');

        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::get('/{order}/edit', [OrderController::class, 'edit'])->name('edit');
        Route::put('/{order}', [OrderController::class, 'update'])->name('update');
        Route::delete('/{order}', [OrderController::class, 'destroy'])->name('destroy');
        Route::patch('/{order}/status', [OrderController::class, 'updateStatus'])->name('update-status');
        Route::get('/export', [OrderController::class, 'export'])->name('export');
        Route::get('/statistics', [OrderController::class, 'statistics'])->name('statistics');


        // AJAX routes
        Route::get('/customer/{id}/details', [OrderController::class, 'getCustomerDetails'])->name('customer.details');
        Route::get('/dress-type/{id}/details', [OrderController::class, 'getDressTypeDetails'])->name('dress-type.details');
    });
});

// Customers
// Replace your customer routes with:
Route::prefix('dashboard/customers')->name('customers.')->group(function () {
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/create', [CustomerController::class, 'create'])->name('create');
    Route::post('/', [CustomerController::class, 'store'])->name('store');
    Route::get('/{customer}', [CustomerController::class, 'show'])->name('show');
    Route::get('/{customer}/edit', [CustomerController::class, 'edit'])->name('edit');
    Route::put('/{customer}', [CustomerController::class, 'update'])->name('update');
    Route::delete('/{customer}', [CustomerController::class, 'destroy'])->name('destroy');
});

// Tailors
Route::prefix('dashboard/tailors')->name('tailors.')->group(function () {
    Route::get('/', function () {
        return view('dashboard.tailors.index');
    })->name('index');
    Route::get('/create', function () {
        return view('dashboard.tailors.create');
    })->name('create');

    Route::get('/{id}', function ($id) {
        return view('dashboard.tailors.show', ['id' => $id]);
    })->name('show');

    Route::get('/{id}/edit', function ($id) {
        return view('dashboard.tailors.edit', ['id' => $id]);
    })->name('edit');
});

// Tailor Assignments
Route::get('tailor-assignments', function () {
    return view('dashboard.tailor-assignments.index');
})->name('tailor-assignments.index');

// Dress Types
Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('dress-types')->name('dress-types.')->group(function () {
        Route::get('/', [DressTypeController::class, 'index'])->name('index');
        Route::get('/create', [DressTypeController::class, 'create'])->name('create');
        Route::post('/', [DressTypeController::class, 'store'])->name('store');
        Route::get('/{dressType}/edit', [DressTypeController::class, 'edit'])->name('edit');
        Route::put('/{dressType}', [DressTypeController::class, 'update'])->name('update');
        Route::delete('/{dressType}', [DressTypeController::class, 'destroy'])->name('destroy');
        Route::patch('/{dressType}/toggle-status', [DressTypeController::class, 'toggleStatus'])->name('toggle-status');
        Route::post('/import', [DressTypeController::class, 'import'])->name('import');
        Route::get('/export', [DressTypeController::class, 'export'])->name('export');
        Route::get('/stats', [DressTypeController::class, 'stats'])->name('stats');
    });

    Route::get('/dress-types/{dressType}', [DressTypeController::class, 'show'])->name('api.dress-types.show');
    Route::get('/dress-types/stats/popularity', [DressTypeController::class, 'popularityChart'])->name('api.dress-types.popularity');
});

// Fabrics
Route::prefix('fabrics')->name('fabrics.')->group(function () {
    Route::get('/', function () {
        return view('dashboard.fabrics.index');
    })->name('index');

    Route::get('/create', function () {
        return view('dashboard.fabrics.create');
    })->name('create');

    Route::get('/{id}', function ($id) {
        return view('dashboard.fabrics.show', ['id' => $id]);
    })->name('show');

    Route::get('/{id}/edit', function ($id) {
        return view('dashboard.fabrics.edit', ['id' => $id]);
    })->name('edit');
});

// Payments
Route::prefix('payments')->name('payments.')->group(function () {
    Route::get('/', function () {
        return view('dashboard.dashboard');
    })->name('index');
    Route::get('/create', function () {
        return view('dashboard.dashboard');
    })->name('create');
    Route::get('/overdue', function () {
        return view('dashboard.dashboard');
    })->name('overdue');
});

// Expenses
Route::get('expenses', function () {
    return view('dashboard.dashboard');
})->name('expenses.index');

// Reports
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/sales', function () {
        return view('dashboard.dashboard');
    })->name('sales');
    Route::get('/tailor-performance', function () {
        return view('dashboard.dashboard');
    })->name('tailor-performance');
    Route::get('/inventory', function () {
        return view('dashboard.dashboard');
    })->name('inventory');
    Route::get('/financial', function () {
        return view('dashboard.dashboard');
    })->name('financial');
});

// Branches
Route::prefix('dashboard/branches')->name('branches.')->group(function () {
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
// Route::prefix('settings')->name('settings.')->group(function () {
//     Route::get('/', [SettingController::class, 'index'])->name('index');
//     Route::put('/', [SettingController::class, 'update'])->name('update');
//     Route::get('/general', [SettingController::class, 'general'])->name('general');
//     Route::post('/general', [SettingController::class, 'updateGeneral'])->name('update.general');
//     Route::get('/branch/{branch}', [SettingController::class, 'branch'])->name('branch');
//     Route::put('/branch/{branch}', [SettingController::class, 'updateBranch'])->name('update.branch');
// });

// Settings Routes
Route::prefix('dashboard/settings')->name('settings.')->group(function () {
    Route::get('/', [SettingController::class, 'index'])->name('index');

    // General Settings
    Route::get('/general', [SettingController::class, 'general'])->name('general');
    Route::put('/general', [SettingController::class, 'updateGeneral'])->name('update.general');

    // Branch Settings
    Route::get('/branch/{branch}', [SettingController::class, 'branch'])->name('branch');
    Route::put('/branch/{branch}', [SettingController::class, 'updateBranch'])->name('update.branch');

    // Lookup Tables
    Route::get('/lookups', [SettingController::class, 'lookups'])->name('lookups');

    // System Info
    Route::get('/system-info', [SettingController::class, 'systemInfo'])->name('system-info');

    // Backup
    Route::get('/backup', [SettingController::class, 'backup'])->name('backup');

    // Logo Management
    Route::get('/logo/delete/{type}/{branch?}', [SettingController::class, 'deleteLogo'])->name('delete.logo');

    // Reset to General
    Route::post('/branch/{branch}/reset', [SettingController::class, 'resetToGeneral'])->name('reset.to.general');
});

// Users
Route::get('users', function () {
    return view('dashboard.dashboard');
})->name('users.index');

// Discounts
Route::get('discounts', function () {
    return view('dashboard.dashboard');
})->name('discounts.index');

require __DIR__ . '/auth.php';
