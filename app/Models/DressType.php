<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DressType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'base_price',
        'estimated_days',
        'is_active',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'estimated_days' => 'integer',
        'is_active' => 'boolean'
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class, 'applicable_dress_type_id');
    }

    public function measurementTemplates()
    {
        return $this->hasMany(MeasurementTemplate::class);
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
