<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'avatar',
        'language_preference',
        'role_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function customers()
    {
        return $this->hasMany(Customer::class, 'assigned_to');
    }

    public function leads()
    {
        return $this->hasMany(Lead::class, 'assigned_to');
    }

    public function deals()
    {
        return $this->hasMany(Deal::class, 'assigned_to');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class)->whereNull('read_at');
    }

    public function hasRole(string $role): bool
    {
        return $this->role && $this->role->name === $role;
    }

    public function isAdmin(): bool
    {
        return $this->hasRole('admin');
    }

    public function isManager(): bool
    {
        return $this->hasRole('manager') || $this->hasRole('sales_manager');
    }

    public function isAgent(): bool
    {
        return $this->hasRole('agent')
            || $this->hasRole('sales_executive')
            || $this->hasRole('support_agent');
    }

    public function isSalesExecutive(): bool
    {
        return $this->hasRole('agent') || $this->hasRole('sales_executive');
    }

    public function isSalesManager(): bool
    {
        return $this->hasRole('manager') || $this->hasRole('sales_manager');
    }

    public function isSupportAgent(): bool
    {
        return $this->hasRole('support_agent');
    }

    /**
     * Can this user manage (create/edit/delete) other users?
     */
    public function canManageUsers(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Can this user view all records, or only their own?
     */
    public function canViewAll(): bool
    {
        return $this->isAdmin() || $this->isManager();
    }

    /**
     * Can this user view reports?
     */
    public function canViewReports(): bool
    {
        return $this->isAdmin() || $this->isManager();
    }

    /**
     * Can this user configure CRM settings?
     */
    public function canConfigureCrm(): bool
    {
        return $this->isAdmin();
    }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=6366f1&color=fff';
    }
}
