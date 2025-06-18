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
        Schema::table('Uzytkownicy', function (Blueprint $table) {
            // Dodajemy brakującą kolumnę zaraz po kolumnie 'jest_aktywny'
            $table->timestamp('email_verified_at')->nullable()->after('jest_aktywny');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Uzytkownicy', function (Blueprint $table) {
            $table->dropColumn('email_verified_at');
        });
    }
};