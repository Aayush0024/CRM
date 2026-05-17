<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'mobile',
        'job_title', 'department', 'customer_id', 'preferred_language',
        'notes', 'created_by',
    ];

    protected static function booted(): void
    {
        static::saving(function (Contact $contact) {
            if ($contact->preferred_language === null || $contact->preferred_language === '') {
                $contact->preferred_language = 'en';
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
