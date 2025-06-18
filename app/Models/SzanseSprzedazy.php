<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SzanseSprzedazy extends Model
{
    use HasFactory;

    protected $table = 'SzanseSprzedazy';
    protected $primaryKey = 'id_szansy';
    const CREATED_AT = 'utworzono_at';
    const UPDATED_AT = 'zaktualizowano_at';

    protected $fillable = [
        'id_klienta',
        'id_kontaktu',
        'nazwa',
        'etap',
        'wartosc',
        'data_zamkniecia',
        'opis',
    ];

    protected $casts = [
        'data_zamkniecia' => 'date',
        'wartosc' => 'decimal:2',
    ];

    public function klient(): BelongsTo
    {
        return $this->belongsTo(Klient::class, 'id_klienta', 'id_klienta');
    }

    public function kontakt(): BelongsTo
    {
        return $this->belongsTo(Kontakt::class, 'id_kontaktu', 'id_kontaktu');
    }
    
    public function notatki(): HasMany
    {
        return $this->hasMany(Notatka::class, 'id_szansy', 'id_szansy');
    }
}