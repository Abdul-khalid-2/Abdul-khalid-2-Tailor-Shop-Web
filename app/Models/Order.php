<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'order_number',
        'customer_id',
        'branch_id',
        'status_id',
        'payment_status_id',
        'order_date',
        'delivery_date',
        'estimated_date',
        'total_amount',
        'advance_amount',
        'remaining_amount',
        'discount_amount',
        'final_amount',
        'notes',
        'internal_notes',
        'created_by',
        'updated_by',
        'order_type'
    ];

    protected $casts = [
        'order_date' => 'date',
        'delivery_date' => 'date',
        'estimated_date' => 'date',
        'total_amount' => 'decimal:2',
        'advance_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_amount' => 'decimal:2'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }

    public function paymentStatus()
    {
        return $this->belongsTo(PaymentStatus::class, 'payment_status_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function discounts()
    {
        return $this->hasMany(OrderDiscount::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
