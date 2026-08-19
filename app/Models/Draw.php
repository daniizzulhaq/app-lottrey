<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Draw extends Model
{
    use HasFactory;

    protected $fillable = [
        'game_id',
        'draw_number',
        'start_time',
        'end_time',
        'result',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'start_time' => 'datetime',
            'end_time' => 'datetime',
            'result' => 'array',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function bets(): HasMany
    {
        return $this->hasMany(GameBet::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeOpen(Builder $query): Builder
    {
        return $query->where(
            'status',
            'open'
        );
    }

    public function scopeCompleted(Builder $query): Builder
    {
        return $query->where(
            'status',
            'completed'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function isExpired(): bool
    {
        return now()->greaterThanOrEqualTo(
            $this->end_time
        );
    }

    public function remainingSeconds(): int
    {
        if ($this->isExpired()) {
            return 0;
        }

        return now()->diffInSeconds(
            $this->end_time
        );
    }
}
