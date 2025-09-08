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
        Schema::table('checkins', function (Blueprint $table) {
            //
            $table->foreign('user_id')
                  ->references('id')
                  ->on('user_memberships')
                  ->onDelete('cascade');

            $table->foreign('shift_id')
                  ->references('id')
                  ->on('shifts')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('checkins', function (Blueprint $table) {
            //
            $table->dropForeign(['user_id']);
            $table->dropForeign(['shift_id']);
        });
    }
};
