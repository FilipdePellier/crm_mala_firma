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
        Schema::create('Notatki', function (Blueprint $table) {
            $table->id('id_notatki');
            $table->foreignId('id_klienta')->nullable()->constrained('Klienci', 'id_klienta')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_leada')->nullable()->constrained('Leady', 'id_leada')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_szansy')->nullable()->constrained('SzanseSprzedazy', 'id_szansy')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_kontaktu')->nullable()->constrained('Kontakty', 'id_kontaktu')->onUpdate('cascade')->onDelete('cascade');
            $table->text('tresc_notatki');
            $table->foreignId('utworzono_przez')->constrained('Uzytkownicy', 'id_uzytkownika')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamp('utworzono_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Notatki');
    }
};