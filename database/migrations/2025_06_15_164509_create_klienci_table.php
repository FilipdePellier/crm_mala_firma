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
        Schema::create('Klienci', function (Blueprint $table) {
            $table->id('id_klienta');
            $table->string('imie', 100);
            $table->string('nazwisko', 100);
            $table->string('nazwa_firmy', 255)->nullable();
            $table->string('email', 255)->unique()->nullable();
            $table->string('telefon', 20)->nullable();
            $table->string('adres', 255)->nullable();
            $table->string('miasto', 100)->nullable();
            $table->string('wojewodztwo', 100)->nullable();
            $table->string('kod_pocztowy', 20)->nullable();
            $table->string('kraj', 100)->nullable();
            $table->timestamp('utworzono_at')->useCurrent();
            $table->timestamp('zaktualizowano_at')->useCurrent()->useCurrentOnUpdate();

            // Indeksy zdefiniowane w SQL
            $table->index('email', 'idx_klienci_email');
            $table->index('nazwa_firmy', 'idx_klienci_nazwa_firmy');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Klienci');
    }
};