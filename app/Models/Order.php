<?php

namespace App\Models;

use App\Models\Concerns\BelongsToBranch;
use App\Models\Setting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use BelongsToBranch, SoftDeletes, HasFactory;

    protected $fillable = [
        'order_number',
        'customer_id',
        'tailor_id',
        'branch_id',
        'status_id',
        'order_date',
        'delivery_date',
        'actual_delivery_date',
        'order_label',
        'total_suits',
        'total_amount',
        'advance_paid',
        'balance_due',
        'tailor_fee_total',
        'tailor_fee_paid',
        'tailor_fee_balance',
        'notes',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'order_date' => 'date',
        'delivery_date' => 'date',
        'actual_delivery_date' => 'date',
        'total_suits' => 'integer',
        'total_amount' => 'decimal:2',
        'advance_paid' => 'decimal:2',
        'balance_due' => 'decimal:2',
        'tailor_fee_total' => 'decimal:2',
        'tailor_fee_paid' => 'decimal:2',
        'tailor_fee_balance' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Boot — auto-generate order_number (ORD-YYYY-0001)
    |--------------------------------------------------------------------------
    */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Order $order) {
            if (empty($order->order_number)) {
                $year = now()->year;
                $count = static::withTrashed()
                    ->whereYear('created_at', $year)
                    ->count() + 1;
                $order->order_number = 'ORD-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function tailor()
    {
        return $this->belongsTo(Tailor::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function status()
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }

    public function suits()
    {
        return $this->hasMany(Suit::class)->orderBy('sort_order');
    }

    public function measurement()
    {
        return $this->hasOne(Measurement::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(OrderStatusLog::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */
    public function scopePending(Builder $query): Builder
    {
        return $query->whereHas('status', fn ($q) => $q->where('name', 'Pending'));
    }

    public function scopeInProgress(Builder $query): Builder
    {
        return $query->whereHas('status', fn ($q) => $q->where('name', 'In Progress'));
    }

    public function scopeReady(Builder $query): Builder
    {
        return $query->whereHas('status', fn ($q) => $q->where('name', 'Ready'));
    }

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->whereNotNull('delivery_date')
            ->whereDate('delivery_date', '<', now()->toDateString())
            ->whereHas('status', fn ($q) => $q->whereNotIn('name', ['Delivered', 'Cancelled']));
    }

    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */
    public function isOverdue(): bool
    {
        if (empty($this->delivery_date)) {
            return false;
        }

        $statusName = $this->status?->name;

        return $this->delivery_date->isPast()
            && ! in_array($statusName, ['Delivered', 'Cancelled'], true);
    }

    /**
     * Build a "click to chat" WhatsApp URL containing a plain-text bill summary.
     * Resolves the order branch's shop setting (falling back to the global one).
     */
    public function billWhatsappUrl(): string
    {
        $setting = $this->branch?->setting
            ?? Setting::whereNull('branch_id')->first()
            ?? Setting::first();

        $currency = $setting->currency_symbol ?? 'Rs';
        $shopName = $setting->shop_name ?? config('app.name', 'Tailor Shop');
        $fmt = fn ($amount) => $currency . ' ' . number_format((float) $amount, 0);

        // Digits only; a leading 0 (local format) becomes +92 (Pakistan).
        $phone = preg_replace('/\D+/', '', (string) ($this->customer->phone ?? ''));
        if (str_starts_with($phone, '0')) {
            $phone = '92' . substr($phone, 1);
        }

        $lines = [
            "*{$shopName}*",
            "Bill / Receipt — Order #{$this->order_number}",
            '',
            "Customer: {$this->customer->name}",
            'Order Date: ' . $this->order_date->format('d M, Y'),
        ];
        if ($this->delivery_date) {
            $lines[] = 'Delivery Date: ' . $this->delivery_date->format('d M, Y');
        }
        $lines[] = '';
        $lines[] = '*Items*';
        foreach ($this->suits as $suit) {
            $lines[] = "• {$suit->color} x{$suit->quantity} — " . $fmt($suit->suit_total);
        }
        $lines[] = '';
        $lines[] = 'Total: ' . $fmt($this->total_amount);
        $lines[] = 'Advance Paid: ' . $fmt($this->advance_paid);
        $lines[] = 'Balance Due: ' . $fmt($this->balance_due);
        $lines[] = '';
        $lines[] = $setting->receipt_footer ?? 'Thank you for your business!';

        return 'https://wa.me/' . $phone . '?text=' . rawurlencode(implode("\n", $lines));
    }

    /**
     * Recalculate suit/payment totals from related suits, then persist.
     */
    public function recalculate(): void
    {
        $this->total_suits = (int) $this->suits()->sum('quantity');
        $this->total_amount = (float) $this->suits()->sum('suit_total');
        $this->balance_due = (float) $this->total_amount - (float) $this->advance_paid;
        $this->tailor_fee_balance = (float) $this->tailor_fee_total - (float) $this->tailor_fee_paid;

        $this->saveQuietly();
    }
}
