<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->enum('type', [
                'TOPUP',
                'GAME',
                'WIN',
                'REDEEM',
                'REFUND'
            ]);

            /*
             * Selalu simpan amount sebagai
             * nilai perubahan saldo.
             */
            $table->decimal('amount', 15, 2);

            $table->decimal('balance_before', 15, 2);

            $table->decimal('balance_after', 15, 2);

            /*
             * Contoh:
             * Topup
             * GameBet
             * Redemption
             */
            $table->string('reference_type')->nullable();

            $table->unsignedBigInteger('reference_id')->nullable();

            $table->string('description')->nullable();

            $table->timestamps();

            $table->index([
                'user_id',
                'type'
            ]);

            $table->index([
                'reference_type',
                'reference_id'
            ]);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
