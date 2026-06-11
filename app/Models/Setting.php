<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'shop_name',
        'shop_phone',
        'shop_email',
        'shop_address',
        'currency',
        'currency_symbol',
        'default_delivery_days',
        'tax_rate',
        'receipt_header',
        'receipt_footer',
        'receipt_prefix',
        'next_receipt_number',
        'measurement_fields',
        'dress_type_measurements',
        'logo_path',
        'favicon_path',
        'sms_notifications',
        'email_notifications',
        'reminder_days_before',
    ];

    protected $casts = [
        'measurement_fields' => 'array',
        'dress_type_measurements' => 'array',
        'next_receipt_number' => 'integer',
        'default_delivery_days' => 'integer',
        'tax_rate' => 'decimal:2',
        'sms_notifications' => 'boolean',
        'email_notifications' => 'boolean',
        'reminder_days_before' => 'integer'
    ];

    /**
     * Public URL for the shop logo. New logos live under public/assets/branch_{id}/logos
     * (served directly via asset()); older ones used the storage disk.
     */
    public function getLogoUrlAttribute(): ?string
    {
        if (! $this->logo_path) {
            return null;
        }

        return str_starts_with($this->logo_path, 'assets/')
            ? asset($this->logo_path)
            : \Illuminate\Support\Facades\Storage::url($this->logo_path);
    }

    /** Public URL for the favicon; falls back to the logo when none is set. */
    public function getFaviconUrlAttribute(): ?string
    {
        if (! $this->favicon_path) {
            return $this->logo_url;
        }

        return str_starts_with($this->favicon_path, 'assets/')
            ? asset($this->favicon_path)
            : \Illuminate\Support\Facades\Storage::url($this->favicon_path);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
