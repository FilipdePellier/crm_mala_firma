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
        Schema::create('SzanseSprzedazy', function (Blueprint $table) {
            $table->id('id_szansy');
            $table->foreignId('id_klienta')->constrained('Klienci', 'id_klienta')->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('id_kontaktu')->nullable()->constrained('Kontakty', 'id_kontaktu')->onUpdate('cascade')->onDelete('set null');
            $table->string('nazwa', 255);
            $table->string('etap', 50);
            $table->decimal('wartosc', 10, 2)->nullable();
            $table->date('data_zamkniecia')->nullable();
            $table->text('opis')->nullable();
            $table->timestamp('utworzono_at')->useCurrent();
            $table->timestamp('zaktualizowano_at')->useCurrent()->useCurrentOnUpdate();
            
            // Indeksy zdefiniowane w SQL
            $table->index('etap', 'idx_szanse_sprzedazy_etap');
            $table->index('data_zamkniecia', 'idx_szanse_sprzedazy_data_zamkniecia');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('SzanseSprzedazy');
    }
};