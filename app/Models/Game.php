<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Game extends Model
{
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | Fillable
    |--------------------------------------------------------------------------
    */

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'banner',
        'description',
        'status',
        'configuration',
    ];


    /*
    |--------------------------------------------------------------------------
    | Casts
    |--------------------------------------------------------------------------
    */

    protected $casts = [
        'configuration' => 'array',
    ];


    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    /**
     * Game memiliki banyak draw.
     */
    public function draws(): HasMany
    {
        return $this->hasMany(Draw::class);
    }


    /**
     * Game memiliki banyak bet.
     */
    public function bets(): HasMany
    {
        return $this->hasMany(GameBet::class);
    }


    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Mengambil game yang aktif.
     */
    public function scopeActive($query)
    {
        return $query->where(
            'status',
            'active'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Helper
    |--------------------------------------------------------------------------
    */

    /**
     * Cek apakah game aktif.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
