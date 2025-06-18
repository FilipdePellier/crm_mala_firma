<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kontakt extends Model
{
    use HasFactory;

    protected $table = 'Kontakty';
    protected $primaryKey = 'id_kontaktu';
    const CREATED_AT = 'utworzono_at';
    const UPDATED_AT = 'zaktualizowano_at';

    protected $fillable = [
        'id_klienta',
        'imie',
        'nazwisko',
        'stanowisko',
        'email',
        'telefon',
    ];


    public function klient(): BelongsTo
    {
        return $this->belongsTo(Klient::class, 'id_klienta', 'id_klienta');
    }

    /**
     * Pobierz szanse sprzedaży powiązane z tym kontaktem.
     */
    public function szanseSprzedazy(): HasMany
    {
        return $this->hasMany(SzanseSprzedazy::class, 'id_kontaktu', 'id_kontaktu');
    }

    /**
     * Pobierz notatki powiązane z tym kontaktem.
     */
    public function notatki(): HasMany
    {
        return $this->hasMany(Notatka::class, 'id_kontaktu', 'id_kontaktu');
    }
}