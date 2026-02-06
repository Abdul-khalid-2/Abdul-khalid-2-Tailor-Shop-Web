<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'old_status_id',
        'new_status_id',
        'notes',
        'changed_by'
    ];

    protected $casts = [
        'changed_at' => 'datetime'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function oldStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'old_status_id');
    }

    public function newStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'new_status_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
