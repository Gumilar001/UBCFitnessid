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
        Schema::table('transactions', function (Blueprint $table) {
            //
            $table->string('gender')->nullable()->after('emergency_contact');
            $table->string('golongan_darah')->nullable()->after('gender');
            $table->string('identitas')->nullable()->after('golongan_darah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            //
            $table->dropColumn('gender');
            $table->dropColumn('golongan_darah');
            $table->dropColumn('identitas');            
        });
    }
};
