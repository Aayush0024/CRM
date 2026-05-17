<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'value', 'currency', 'stage', 'probability',
        'expected_close_date', 'actual_close_date', 'status',
        'description', 'lost_reason', 'customer_id', 'lead_id',
        'contact_id', 'assigned_to', 'created_by',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'probability' => 'integer',
        'expected_close_date' => 'date',
        'actual_close_date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tasks()
    {
        return $this->morphMany(Task::class, 'taskable');
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'notable');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function getStageColorAttribute(): string
    {
        return match($this->stage) {
            'prospecting' => 'blue',
            'qualification' => 'indigo',
            'proposal' => 'yellow',
            'negotiation' => 'orange',
            'closed_won' => 'green',
            'closed_lost' => 'red',
            default => 'gray',
        };
    }

    public function getFormattedValueAttribute(): string
    {
        return number_format($this->value, 2) . ' ' . $this->currency;
    }
}
