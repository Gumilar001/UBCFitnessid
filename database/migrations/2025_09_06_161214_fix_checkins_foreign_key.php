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
        //
        Schema::table('checkins', function (Blueprint $table) {
            // Hapus foreign key lama
            $table->dropForeign(['user_id']);

            // Tambahkan foreign key baru -> ke tabel users
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('checkins', function (Blueprint $table) {
            $table->dropForeign(['user_id']);

            // Balikin lagi ke user_memberships (jika rollback)
            $table->foreign('user_id')
                  ->references('id')
                  ->on('user_memberships')
                  ->onDelete('cascade');
        });
    }
};
