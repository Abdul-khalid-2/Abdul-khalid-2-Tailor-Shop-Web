<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Measurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'length',
        'shoulder',
        'chest',
        'waist',
        'hip',
        'sleeve',
        'collar',
        'trouser_length',
        'trouser_waist',
        'thigh',
        'bottom_opening',
        'notes',
    ];

    protected $casts = [
        'length' => 'decimal:1',
        'shoulder' => 'decimal:1',
        'chest' => 'decimal:1',
        'waist' => 'decimal:1',
        'hip' => 'decimal:1',
        'sleeve' => 'decimal:1',
        'collar' => 'decimal:1',
        'trouser_length' => 'decimal:1',
        'trouser_waist' => 'decimal:1',
        'thigh' => 'decimal:1',
        'bottom_opening' => 'decimal:1',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
