<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;










Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/', function () {
    return view('welcome');
});

// Orders
Route::prefix('orders')->name('orders.')->group(function () {
    Route::get('/', function () {
        return 'index.blade.php';
    })->name('index');
    Route::get('/create', function () {
        return 'create.blade.php';
    })->name('create');
    Route::get('/pending', function () {
        return 'pending.blade.php';
    })->name('pending');
    Route::get('/in-progress', function () {
        return 'inprogress.blade.php';
    })->name('in-progress');
    Route::get('/completed', function () {
        return 'completed.blade.php';
    })->name('completed');
});

// Customers
Route::prefix('customers')->name('customers.')->group(function () {
    Route::get('/', function () {
        return 'index.blade.php';
    })->name('index');
    Route::get('/create', function () {
        return 'create.blade.php';
    })->name('create');
});

// Tailors
Route::prefix('tailors')->name('tailors.')->group(function () {
    Route::get('/', function () {
        return 'index.blade.php';
    })->name('index');
    Route::get('/create', function () {
        return 'create.blade.php';
    })->name('create');
});

// Tailor Assignments
Route::get('tailor-assignments', function () {
    return 'create.blade.php';
})->name('tailor-assignments.index');

// Dress Types
Route::get('dress-types', function () {
    return 'create.blade.php';
})->name('dress-types.index');

// Fabrics
Route::prefix('fabrics')->name('fabrics.')->group(function () {
    Route::get('/', function () {
        return 'create.blade.php';
    })->name('index');
    Route::get('/create', function () {
        return 'create.blade.php';
    })->name('create');
});

// Payments
Route::prefix('payments')->name('payments.')->group(function () {
    Route::get('/', function () {
        return 'create.blade.php';
    })->name('index');
    Route::get('/create', function () {
        return 'create.blade.php';
    })->name('create');
    Route::get('/overdue', function () {
        return 'create.blade.php';
    })->name('overdue');
});

// Expenses
Route::get('expenses', function () {
    return 'create.blade.php';
})->name('expenses.index');

// Reports
Route::prefix('reports')->name('reports.')->group(function () {
    Route::get('/sales', function () {
        return 'create.blade.php';
    })->name('sales');
    Route::get('/tailor-performance', function () {
        return 'create.blade.php';
    })->name('tailor-performance');
    Route::get('/inventory', function () {
        return 'create.blade.php';
    })->name('inventory');
    Route::get('/financial', function () {
        return 'create.blade.php';
    })->name('financial');
});

// Settings
Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/general', function () {
        return 'create.blade.php';
    })->name('general');
});

// Branches
Route::get('branches', function () {
    return 'create.blade.php';
})->name('branches.index');

// Users
Route::get('users', function () {
    return 'create.blade.php';
})->name('users.index');

// Discounts
Route::get('discounts', function () {
    return 'create.blade.php';
})->name('discounts.index');

require __DIR__ . '/auth.php';
