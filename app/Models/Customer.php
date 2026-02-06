<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'user_id',
        'phone_normalized',
        'address',
        'reference',
        'notes',
        'branch_id',
        'created_by',
        'updated_by'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function measurementTemplates()
    {
        return $this->hasMany(MeasurementTemplate::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
