<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tailor extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'cnic',
        'user_id',
        'address',
        'specializations',
        'employment_type',
        'salary',
        'commission_rate',
        'status',
        'branch_id',
        'joining_date',
        'notes'
    ];

    protected $casts = [
        'specializations' => 'array',
        'salary' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'joining_date' => 'date'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function assignments()
    {
        return $this->hasMany(TailorAssignment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
