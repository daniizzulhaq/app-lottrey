<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WebsiteSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
    ];

    /*
    |--------------------------------------------------------------------------
    | Helper
    |--------------------------------------------------------------------------
    */

    public static function get(
        string $key,
        mixed $default = null
    ): mixed {
        $setting = static::where(
            'key',
            $key
        )->first();

        if (!$setting) {
            return $default;
        }

        return match ($setting->type) {
            'number' => is_numeric($setting->value)
                ? (float) $setting->value
                : $default,

            'boolean' => filter_var(
                $setting->value,
                FILTER_VALIDATE_BOOLEAN
            ),

            'json' => json_decode(
                $setting->value,
                true
            ),

            default => $setting->value,
        };
    }
}
