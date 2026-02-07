<?php

use App\Http\Controllers\BranchController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
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
Route::prefix('dashboard/orders')->name('orders.')->group(function () {
    Route::get('/', function () {
        return view('dashboard.orders.index');
    })->name('index');
    Route::get('/create', function () {
        return view('dashboard.orders.create');
    })->name('create');
    Route::get('/pending', function () {
        return view('dashboard.orders.pending');
    })->name('pending');
    Route::get('/in-progress', function () {
        return view('dashboard.orders.in-progress');
    })->name('in-progress');
    Route::get('/completed', function () {
        return view('dashboard.orders.completed');
    })->name('completed');

    Route::get('/{id}/edit', function ($id) {
        return view('dashboard.orders.edit', ['id' => $id]);
    })->name('edit');

    Route::get('/{id}', function ($id) {
        return view('dashboard.orders.show', ['id' => $id]);
    })->name('show');
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
Route::get('dress-types', function () {
    return view('dashboard.dress-types.index');
})->name('dress-types.index');

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
