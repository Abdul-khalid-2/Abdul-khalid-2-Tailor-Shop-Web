<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TailorAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_item_id',
        'tailor_id',
        'status_id',
        'assign_date',
        'expected_date',
        'start_date',
        'completion_date',
        'stitching_charge',
        'advance_paid',
        'remaining_payment',
        'progress_percentage',
        'progress_notes',
        'assigned_by',
        'created_by',
        'updated_by',
        'instructions',
        'notes'
    ];

    protected $casts = [
        'assign_date' => 'date',
        'expected_date' => 'date',
        'start_date' => 'date',
        'completion_date' => 'date',
        'stitching_charge' => 'decimal:2',
        'advance_paid' => 'decimal:2',
        'remaining_payment' => 'decimal:2',
        'progress_percentage' => 'integer'
    ];

    public function orderItem()
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function tailor()
    {
        return $this->belongsTo(Tailor::class);
    }

    public function status()
    {
        return $this->belongsTo(AssignmentStatus::class, 'status_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
