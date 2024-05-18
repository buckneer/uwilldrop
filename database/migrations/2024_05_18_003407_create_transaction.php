<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('type')->default(0);
            $table->unsignedBigInteger('card_id');
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount', 9, 2);
            $table->timestamps();

            $table->foreign('card_id')->references('id')->on('billing');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
