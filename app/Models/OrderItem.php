<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'dress_type_id',
        'item_name',
        'quantity',
        'price',
        'total',
        'item_status',
        'instructions',
        'item_type'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
        'quantity' => 'integer'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function dressType()
    {
        return $this->belongsTo(DressType::class);
    }

    public function measurements()
    {
        return $this->hasMany(Measurement::class);
    }

    public function currentMeasurement()
    {
        return $this->hasOne(Measurement::class)->where('is_current', true);
    }

    public function tailorAssignments()
    {
        return $this->hasMany(TailorAssignment::class);
    }
    public function tailorAssignment()
    {
        return $this->hasOne(TailorAssignment::class);
    }

    public function fabricTransactions()
    {
        return $this->hasMany(FabricTransaction::class);
    }
}
