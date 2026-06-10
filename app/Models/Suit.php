<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Suit extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'color',
        'quantity',
        'stitching_charge',
        'button_charge',
        'other_charge',
        'other_charge_note',
        'suit_total',
        'notes',
        'sort_order',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'stitching_charge' => 'decimal:2',
        'button_charge' => 'decimal:2',
        'other_charge' => 'decimal:2',
        'suit_total' => 'decimal:2',
        'sort_order' => 'integer',
    ];

    protected static function boot()
    {
        parent::boot();

        // Auto-calculate row total before saving: (stitch + button + other) * qty
        static::saving(function (Suit $suit) {
            $suit->suit_total = ($suit->stitching_charge + $suit->button_charge + $suit->other_charge) * $suit->quantity;
        });

        // Keep the parent order totals in sync
        static::saved(function (Suit $suit) {
            $suit->order?->recalculate();
        });

        static::deleted(function (Suit $suit) {
            $suit->order?->recalculate();
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
