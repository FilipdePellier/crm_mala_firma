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
        Schema::create('Uzytkownicy', function (Blueprint $table) {
            $table->id('id_uzytkownika');
            $table->string('nazwa_uzytkownika', 100)->unique();
            $table->string('haslo', 255);
            $table->string('imie', 100);
            $table->string('nazwisko', 100);
            $table->string('email', 255)->unique();
            $table->string('rola', 50)->default('Uzytkownik');
            $table->boolean('jest_aktywny')->default(true);
            $table->timestamp('utworzono_at')->useCurrent();
            $table->timestamp('zaktualizowano_at')->useCurrent()->useCurrentOnUpdate();
            
            // Indeks zdefiniowany w SQL
            $table->index('email', 'idx_uzytkownicy_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Uzytkownicy');
    }
};