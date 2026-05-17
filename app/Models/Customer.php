<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'company', 'email', 'phone', 'mobile',
        'address', 'city', 'state', 'country', 'pincode',
        'website', 'industry', 'source', 'status',
        'preferred_language', 'notes', 'assigned_to', 'created_by',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::saving(function (Customer $customer) {
            if ($customer->preferred_language === null || $customer->preferred_language === '') {
                $customer->preferred_language = 'en';
            }
        });
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function deals()
    {
        return $this->hasMany(Deal::class);
    }

    public function tasks()
    {
        return $this->morphMany(Task::class, 'taskable');
    }

    /**
     * Polymorphic note rows (not the same as the "notes" text column on customers).
     */
    public function noteRecords()
    {
        return $this->morphMany(Note::class, 'notable');
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'customer_tags');
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'active' => 'green',
            'inactive' => 'gray',
            'prospect' => 'blue',
            'churned' => 'red',
            default => 'gray',
        };
    }
}
