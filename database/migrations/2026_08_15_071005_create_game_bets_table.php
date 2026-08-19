<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_bets', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('game_id')
                ->constrained('games')
                ->cascadeOnDelete();

            $table->foreignId('draw_id')
                ->constrained('draws')
                ->cascadeOnDelete();

            /*
             * Contoh:
             * {
             *   "first_ball": "big",
             *   "second_ball": "small",
             *   "third_ball": "single"
             * }
             */
            $table->json('selection');

            $table->decimal('amount', 15, 2);

            $table->enum('status', [
                'pending',
                'won',
                'lost',
                'cancelled'
            ])->default('pending');

            /*
             * Hasil yang diperoleh setelah draw.
             */
            $table->json('result')->nullable();

            /*
             * Credit kemenangan.
             * 0 jika kalah.
             */
            $table->decimal('win_amount', 15, 2)
                ->default(0);

            $table->timestamps();

            $table->index([
                'user_id',
                'draw_id'
            ]);

            $table->index([
                'game_id',
                'status'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_bets');
    }
};
