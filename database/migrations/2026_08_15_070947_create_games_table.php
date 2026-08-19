<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('slug')->unique();

            $table->string('icon')->nullable();
            $table->string('banner')->nullable();

            $table->text('description')->nullable();

            $table->enum('status', ['active', 'inactive'])
                ->default('active');

            /*
             * Menyimpan konfigurasi game:
             * - jenis pilihan
             * - nominal credit
             * - payout
             * - aturan game
             */
            $table->json('configuration')->nullable();

            $table->timestamps();

            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
