<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'balance',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'balance' => 'decimal:2',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function games()
    {
        return $this->hasMany(GameBet::class);
    }

    public function bets()
    {
        return $this->hasMany(GameBet::class);
    }

    public function topups()
    {
        return $this->hasMany(Topup::class);
    }

    public function redemptions()
    {
        return $this->hasMany(Redemption::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Admin Actions
    |--------------------------------------------------------------------------
    */

    public function approvedTopups()
    {
        return $this->hasMany(
            Topup::class,
            'approved_by'
        );
    }

    public function approvedRedemptions()
    {
        return $this->hasMany(
            Redemption::class,
            'approved_by'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helper
    |--------------------------------------------------------------------------
    */

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
