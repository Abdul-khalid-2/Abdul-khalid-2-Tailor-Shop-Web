<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'user_id',
        'phone_normalized',
        'address',
        'reference',
        'customer_type',
        'discount_rate',
        'occupation',
        'anniversary_date',
        'profile_photo',
        'preferred_communication',
        'send_welcome_message',
        'notes',
        'branch_id',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'discount_rate' => 'decimal:2',
        'anniversary_date' => 'date',
        'preferred_communication' => 'array',
        'send_welcome_message' => 'boolean',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function measurementTemplates()
    {
        return $this->hasMany(MeasurementTemplate::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for customer's email (from user table)
    public function getEmailAttribute()
    {
        return $this->user ? $this->user->email : null;
    }

    // Get total spent amount
    public function getTotalSpentAttribute()
    {
        return $this->orders()->sum('final_amount');
    }

    // Get orders count
    public function getOrdersCountAttribute()
    {
        return $this->orders()->count();
    }

    // Get last order date
    public function getLastOrderDateAttribute()
    {
        $lastOrder = $this->orders()->latest()->first();
        return $lastOrder ? $lastOrder->order_date : null;
    }

    // Get customer type label
    public function getCustomerTypeLabelAttribute()
    {
        $types = [
            'regular' => 'Regular Customer',
            'vip' => 'VIP Customer',
            'corporate' => 'Corporate Customer',
            'walk_in' => 'Walk-in Customer',
        ];

        return $types[$this->customer_type] ?? $this->customer_type;
    }

    // Scope for active customers (customers with recent orders)
    public function scopeActive($query, $months = 3)
    {
        return $query->whereHas('orders', function ($q) use ($months) {
            $q->where('order_date', '>=', now()->subMonths($months));
        });
    }

    // Scope for new customers (created within last month)
    public function scopeNewCustomers($query)
    {
        return $query->where('created_at', '>=', now()->subMonth());
    }
    // Scope by customer type
    public function scopeType($query, $type)
    {
        return $query->where('customer_type', $type);
    }
}
