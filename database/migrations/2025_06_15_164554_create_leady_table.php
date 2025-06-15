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
        Schema::create('Leady', function (Blueprint $table) {
            $table->id('id_leada');
            $table->string('imie', 100);
            $table->string('nazwisko', 100);
            $table->string('nazwa_firmy', 255)->nullable();
            $table->string('email', 255)->unique()->nullable();
            $table->string('telefon', 20)->nullable();
            $table->string('zrodlo', 100)->nullable();
            $table->string('status', 50)->default('Nowy');
            $table->text('uwagi')->nullable();
            $table->timestamp('utworzono_at')->useCurrent();
            $table->timestamp('zaktualizowano_at')->useCurrent()->useCurrentOnUpdate();

            // Indeksy zdefiniowane w SQL
            $table->index('email', 'idx_leady_email');
            $table->index('status', 'idx_leady_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Leady');
    }
};