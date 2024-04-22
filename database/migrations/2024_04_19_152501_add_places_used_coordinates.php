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
        Schema::table('journeys', function (Blueprint $table) {
            $table->json('from_coordinates')->nullable();
            $table->json('to_coordinates')->nullable();
            $table->datetime('departure_time')->nullable();
            $table->integer('seats')->default(0);
            $table->integer('used_seats')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('journeys', function (Blueprint $table) {
            $table->dropColumn(['from_coordinates', 'to_coordinates', 'seats', 'used_seats', 'departure_time']);
        });
    }
};
