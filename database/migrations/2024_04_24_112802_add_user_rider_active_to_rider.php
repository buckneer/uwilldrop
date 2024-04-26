<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->boolean('user_done')->default(false);
            $table->boolean('driver_done')->default(false);
            $table->unsignedBigInteger('rider_id')->nullable();


            DB::statement('SET FOREIGN_KEY_CHECKS=0;');

            $table->foreign('rider_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rides', function (Blueprint $table) {
            $table->dropForeign(['rider_id']);
            $table->dropColumn(['user_done', 'driver_done', 'rider_id']);
        });
    }
};
