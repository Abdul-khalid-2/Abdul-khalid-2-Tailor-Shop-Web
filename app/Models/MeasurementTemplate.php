<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MeasurementTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'dress_type_id',
        'template_name',
        'measurements',
        'notes',
        'is_default',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'measurements' => 'array',
        'is_default' => 'boolean'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function dressType()
    {
        return $this->belongsTo(DressType::class);
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
