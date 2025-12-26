<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password'
    ];

    protected $hidden = [
        'password',
        'remember_token'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationship: A user can have many roles
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    // Check if user has a specific permission
    public function hasPermission($permission)
    {
        return $this->roles()
            ->whereHas('permissions', function ($query) use ($permission) {
                $query->where('name', $permission);
            })
            ->exists();
    }

    // Optional: Check if user has a specific role
    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }
}
