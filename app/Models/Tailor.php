<?php

namespace App\Models;

use App\Models\Concerns\BelongsToBranch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tailor extends Model
{
    use BelongsToBranch, SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'cnic',
        'profile_photo',
        'address',
        'joining_date',
        'specialty',
        'status',
        'branch_id',
        'total_orders_assigned',
        'total_suits_assigned',
        'orders_completed',
        'orders_pending',
        'total_fee_earned',
        'total_fee_received',
        'total_fee_balance',
        'notes',
    ];

    protected $casts = [
        'joining_date' => 'date',
        'total_orders_assigned' => 'integer',
        'total_suits_assigned' => 'integer',
        'orders_completed' => 'integer',
        'orders_pending' => 'integer',
        'total_fee_earned' => 'decimal:2',
        'total_fee_received' => 'decimal:2',
        'total_fee_balance' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('status', 'active');
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    |
    | Recalculate cached work/payment stats from this tailor's orders.
    | Call after: order assigned, order completed, tailor payment recorded.
    */
    public function syncStats(): void
    {
        $this->total_orders_assigned = $this->orders()->count();
        $this->total_suits_assigned = (int) $this->orders()->sum('total_suits');

        $this->orders_completed = $this->orders()
            ->whereHas('status', fn ($q) => $q->where('name', 'Delivered'))
            ->count();

        $this->orders_pending = $this->orders()
            ->whereHas('status', fn ($q) => $q->whereNotIn('name', ['Delivered', 'Cancelled']))
            ->count();

        $this->total_fee_earned = (float) $this->orders()->sum('tailor_fee_total');
        $this->total_fee_received = (float) $this->orders()->sum('tailor_fee_paid');
        $this->total_fee_balance = (float) $this->total_fee_earned - (float) $this->total_fee_received;

        $this->save();
    }
}
