<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Measurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'height',
        'weight',
        'shoulder',
        'chest',
        'waist',
        'hips',
        'sleeve_length',
        'sleeve_width',
        'collar',
        'bicep',
        'wrist',
        'pant_length',
        'inseam',
        'thigh',
        'knee',
        'bottom',
        'ankle',
        'additional_measurements',
        'notes',
        'fitting_preferences',
        'version',
        'is_current',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'height' => 'decimal:1',
        'weight' => 'decimal:1',
        'shoulder' => 'decimal:1',
        'chest' => 'decimal:1',
        'waist' => 'decimal:1',
        'hips' => 'decimal:1',
        'sleeve_length' => 'decimal:1',
        'sleeve_width' => 'decimal:1',
        'collar' => 'decimal:1',
        'bicep' => 'decimal:1',
        'wrist' => 'decimal:1',
        'pant_length' => 'decimal:1',
        'inseam' => 'decimal:1',
        'thigh' => 'decimal:1',
        'knee' => 'decimal:1',
        'bottom' => 'decimal:1',
        'ankle' => 'decimal:1',
        'additional_measurements' => 'array',
        'version' => 'integer',
        'is_current' => 'boolean'
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
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
