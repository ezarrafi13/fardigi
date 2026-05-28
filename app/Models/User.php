<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'username', 'fullname', 'email', 'password',
        'phone', 'address', 'city', 'zip',
        'is_admin', 'user_type', 'cart_data',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_admin' => 'integer',
    ];

    public function isAdmin(): bool
    {
        return $this->is_admin === 1 || $this->user_type === 'admin';
    }

    public function getCartDataArrayAttribute(): array
    {
        return $this->cart_data ? json_decode($this->cart_data, true) : [];
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
