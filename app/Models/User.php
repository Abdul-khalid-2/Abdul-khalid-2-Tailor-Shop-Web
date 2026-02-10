<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles; // Add this line

class User extends Authenticatable
{
    use SoftDeletes, HasFactory, Notifiable,  HasRoles;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role',
        'status',
        'branch_id',
        'email_verified_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // User belongs to a branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Users created or updated records
    public function createdBranches()
    {
        return $this->hasMany(Branch::class, 'created_by');
    }

    public function updatedBranches()
    {
        return $this->hasMany(Branch::class, 'updated_by');
    }

    public function customersCreated()
    {
        return $this->hasMany(Customer::class, 'created_by');
    }

    public function customersUpdated()
    {
        return $this->hasMany(Customer::class, 'updated_by');
    }

    public function paymentsReceived()
    {
        return $this->hasMany(Payment::class, 'received_by');
    }

    // Created dress types
    public function createdDressTypes()
    {
        return $this->hasMany(DressType::class, 'created_by');
    }

    // Updated dress types
    public function updatedDressTypes()
    {
        return $this->hasMany(DressType::class, 'updated_by');
    }

    // Created measurements
    public function createdMeasurements()
    {
        return $this->hasMany(Measurement::class, 'created_by');
    }

    // Updated measurements
    public function updatedMeasurements()
    {
        return $this->hasMany(Measurement::class, 'updated_by');
    }

    // Created fabric transactions
    public function createdFabricTransactions()
    {
        return $this->hasMany(FabricTransaction::class, 'created_by');
    }

    // Tailor assignments
    public function assignedAssignments()
    {
        return $this->hasMany(TailorAssignment::class, 'assigned_by');
    }

    public function createdAssignments()
    {
        return $this->hasMany(TailorAssignment::class, 'created_by');
    }

    public function updatedAssignments()
    {
        return $this->hasMany(TailorAssignment::class, 'updated_by');
    }

    // Payments
    public function createdPayments()
    {
        return $this->hasMany(Payment::class, 'created_by');
    }

    public function updatedPayments()
    {
        return $this->hasMany(Payment::class, 'updated_by');
    }

    // Discounts
    public function createdDiscounts()
    {
        return $this->hasMany(Discount::class, 'created_by');
    }

    // Expenses
    public function approvedExpenses()
    {
        return $this->hasMany(Expense::class, 'approved_by');
    }

    public function createdExpenses()
    {
        return $this->hasMany(Expense::class, 'created_by');
    }

    public function updatedExpenses()
    {
        return $this->hasMany(Expense::class, 'updated_by');
    }

    // Measurement templates
    public function createdMeasurementTemplates()
    {
        return $this->hasMany(MeasurementTemplate::class, 'created_by');
    }

    public function updatedMeasurementTemplates()
    {
        return $this->hasMany(MeasurementTemplate::class, 'updated_by');
    }

    // Order status logs
    public function changedStatusLogs()
    {
        return $this->hasMany(OrderStatusLog::class, 'changed_by');
    }

    // Settings
    public function createdSettings()
    {
        return $this->hasMany(Setting::class, 'created_by');
    }

    public function updatedSettings()
    {
        return $this->hasMany(Setting::class, 'updated_by');
    }

    // Orders
    public function createdOrders()
    {
        return $this->hasMany(Order::class, 'created_by');
    }

    public function updatedOrders()
    {
        return $this->hasMany(Order::class, 'updated_by');
    }
}
