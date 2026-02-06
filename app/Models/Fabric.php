<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fabric extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'fabric_code',
        'type',
        'color',
        'pattern',
        'gsm',
        'description',
        'stock_meter',
        'min_stock_meter',
        'purchase_rate',
        'selling_rate',
        'supplier',
        'supplier_reference',
        'purchase_date',
        'invoice_number',
        'width_inches',
        'shrinkage',
        'wash_care',
        'suitable_for',
        'is_premium',
        'is_imported',
        'is_eco_friendly',
        'storage_location',
        'status',
        'notes',
        'branch_id'
    ];

    protected $casts = [
        'stock_meter' => 'decimal:3',
        'min_stock_meter' => 'decimal:3',
        'purchase_rate' => 'decimal:2',
        'selling_rate' => 'decimal:2',
        'purchase_date' => 'date',
        'width_inches' => 'integer',
        'shrinkage' => 'decimal:2',
        'suitable_for' => 'array',
        'is_premium' => 'boolean',
        'is_imported' => 'boolean',
        'is_eco_friendly' => 'boolean',
        'gsm' => 'integer'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function transactions()
    {
        return $this->hasMany(FabricTransaction::class);
    }
}
