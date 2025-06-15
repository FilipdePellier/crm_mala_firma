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
        Schema::create('Aktywnosci', function (Blueprint $table) {
            $table->id('id_aktywnosci');
            $table->foreignId('id_klienta')->nullable()->constrained('Klienci', 'id_klienta')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('id_leada')->nullable()->constrained('Leady', 'id_leada')->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('id_szansy')->nullable()->constrained('SzanseSprzedazy', 'id_szansy')->onUpdate('cascade')->onDelete('set null');
            $table->string('typ', 50);
            $table->string('temat', 255);
            $table->text('opis')->nullable();
            $table->dateTime('data_aktywnosci');
            $table->string('status', 50)->default('Zrealizowano');
            $table->foreignId('utworzono_przez')->constrained('Uzytkownicy', 'id_uzytkownika')->onUpdate('cascade')->onDelete('restrict');
            $table->timestamp('utworzono_at')->useCurrent();
            $table->timestamp('zaktualizowano_at')->useCurrent()->useCurrentOnUpdate();

            // Indeksy zdefiniowane w SQL
            $table->index('typ', 'idx_aktywnosci_typ');
            $table->index('data_aktywnosci', 'idx_aktywnosci_data');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Aktywnosci');
    }
};