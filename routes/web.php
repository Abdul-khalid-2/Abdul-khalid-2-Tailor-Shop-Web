<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SaleReturnController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountingReportController;
use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\JournalEntryController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\StockTransferController;
use App\Http\Controllers\ShopSettingsController;
use App\Http\Controllers\TaxSettingsController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\BackupController;
use App\Http\Controllers\CustomerReportController;
use App\Http\Controllers\FinancialReportController;
use App\Http\Controllers\InventoryReportController;
use App\Http\Controllers\PurchaseReceiveController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\StaffReportController;
use App\Http\Controllers\StockAdjustmentController;
use App\Http\Controllers\StockMovementController;

Route::get('/', function () {
    return view('welcome');
});







// Transactions Routes
Route::resource('transactions', TransactionController::class);

Route::get('/dashboard', function () {
    return view('dashboard.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
