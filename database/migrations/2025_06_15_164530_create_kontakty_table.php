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
        Schema::create('Kontakty', function (Blueprint $table) {
            $table->id('id_kontaktu');
            $table->foreignId('id_klienta')->nullable()->constrained('Klienci', 'id_klienta')->onUpdate('cascade')->onDelete('set null');
            $table->string('imie', 100);
            $table->string('nazwisko', 100);
            $table->string('stanowisko', 100)->nullable();
            $table->string('email', 255)->unique()->nullable();
            $table->string('telefon', 20)->nullable();
            $table->timestamp('utworzono_at')->useCurrent();
            $table->timestamp('zaktualizowano_at')->useCurrent()->useCurrentOnUpdate();

            // Indeks zdefiniowany w SQL
            $table->index('email', 'idx_kontakty_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Kontakty');
    }
};