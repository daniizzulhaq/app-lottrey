<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'reference_type',
        'reference_id',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'balance_before' => 'decimal:2',
            'balance_after' => 'decimal:2',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Polymorphic Reference
    |--------------------------------------------------------------------------
    */

    public function reference()
    {
        return $this->morphTo();
    }

    /*
    |--------------------------------------------------------------------------
    | Helpers
    |--------------------------------------------------------------------------
    */

    public function isTopup(): bool
    {
        return $this->type === 'TOPUP';
    }

    public function isGame(): bool
    {
        return $this->type === 'GAME';
    }

    public function isWin(): bool
    {
        return $this->type === 'WIN';
    }

    public function isRedeem(): bool
    {
        return $this->type === 'REDEEM';
    }

    public function isRefund(): bool
    {
        return $this->type === 'REFUND';
    }
}
