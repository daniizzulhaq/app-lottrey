<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('draws', function (Blueprint $table) {
            $table->id();

            $table->foreignId('game_id')
                ->constrained('games')
                ->cascadeOnDelete();

            $table->string('draw_number');

            $table->dateTime('start_time');
            $table->dateTime('end_time');

            /*
             * Contoh:
             * ["4", "0", "8", "7", "4"]
             */
            $table->json('result')->nullable();

            $table->enum('status', [
                'upcoming',
                'open',
                'closed',
                'completed'
            ])->default('upcoming');

            $table->timestamps();

            $table->unique([
                'game_id',
                'draw_number'
            ]);

            $table->index([
                'game_id',
                'status'
            ]);

            $table->index('start_time');
            $table->index('end_time');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('draws');
    }
};
