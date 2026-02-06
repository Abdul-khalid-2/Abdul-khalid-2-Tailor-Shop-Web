<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FabricTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'fabric_id',
        'order_item_id',
        'type',
        'meter',
        'rate',
        'total',
        'created_by'
    ];

    protected $casts = [
        'meter' => 'decimal:3',
        'rate' => 'decimal:2',
        'total' => 'decimal:2'
    ];

    public function fabric()
    {
        return $this->belongsTo(Fabric::class);
    }

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
