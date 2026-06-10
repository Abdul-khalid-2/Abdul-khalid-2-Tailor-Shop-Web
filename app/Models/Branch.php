<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'code',
        'phone',
        'email',
        'address',
        'manager_name',
        'manager_phone',
        'manager_email',
        'opening_time',
        'closing_time',
        'working_days',
        'is_active',
        'opening_date',
    ];

    protected $casts = [
        'working_days' => 'array',
        'is_active' => 'boolean',
        'opening_date' => 'date',
    ];

    // Branch has many users
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Branch has many customers
    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    // Branch has many tailors
    public function tailors()
    {
        return $this->hasMany(Tailor::class);
    }

    // Branch has many orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Branch has one setting
    public function setting()
    {
        return $this->hasOne(Setting::class);
    }
}
