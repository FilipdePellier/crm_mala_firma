<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notatka extends Model
{
    use HasFactory;

    protected $table = 'Notatki';
    protected $primaryKey = 'id_notatki';
    const CREATED_AT = 'utworzono_at';
    const UPDATED_AT = null; // Tabela Notatki nie ma kolumny zaktualizowano_at

    protected $fillable = [
        'id_klienta',
        'id_leada',
        'id_szansy',
        'id_kontaktu',
        'tresc_notatki',
        'utworzono_przez',
    ];

    public function uzytkownik(): BelongsTo
    {
        return $this->belongsTo(User::class, 'utworzono_przez', 'id_uzytkownika');
    }

    public function klient(): BelongsTo
    {
        return $this->belongsTo(Klient::class, 'id_klienta', 'id_klienta');
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class, 'id_leada', 'id_leada');
    }

    public function szansaSprzedazy(): BelongsTo
    {
        return $this->belongsTo(SzanseSprzedazy::class, 'id_szansy', 'id_szansy');
    }

    public function kontakt(): BelongsTo
    {
        return $this->belongsTo(Kontakt::class, 'id_kontaktu', 'id_kontaktu');
    }
}