<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'type',
        'value',
        'min_order_amount',
        'applicable_dress_type_id',
        'start_date',
        'end_date',
        'usage_limit',
        'used_count',
        'for_new_customers',
        'for_existing_customers',
        'is_active',
        'created_by'
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'min_order_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'usage_limit' => 'integer',
        'used_count' => 'integer',
        'for_new_customers' => 'boolean',
        'for_existing_customers' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function dressType()
    {
        return $this->belongsTo(DressType::class, 'applicable_dress_type_id');
    }

    public function orders()
    {
        return $this->hasMany(OrderDiscount::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
