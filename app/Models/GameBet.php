<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameBet extends Model
{
    use HasFactory;

   protected $fillable = [
    'user_id',
    'game_id',
    'draw_id',
    'selection',
    'amount',
    'rate',
    'mode',
    'status',
    'result',
    'win_amount',
];

protected $casts = [
    'selection' => 'array',
    'result' => 'array',
    'amount' => 'decimal:2',
    'rate' => 'decimal:2',
    'win_amount' => 'decimal:2',
];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function draw(): BelongsTo
    {
        return $this->belongsTo(Draw::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    public function isWon(): bool
    {
        return $this->status === 'won';
    }

    public function isLost(): bool
    {
        return $this->status === 'lost';
    }

    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }
}
