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

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
