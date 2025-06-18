<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Lead extends Model
{
    use HasFactory;

    protected $table = 'Leady';
    protected $primaryKey = 'id_leada';
    const CREATED_AT = 'utworzono_at';
    const UPDATED_AT = 'zaktualizowano_at';

    protected $fillable = [
        'imie',
        'nazwisko',
        'nazwa_firmy',
        'email',
        'telefon',
        'zrodlo',
        'status',
        'uwagi',
    ];

    /**
     * Pobierz aktywności powiązane z tym leadem.
     */
    public function aktywnosci(): HasMany
    {
        return $this->hasMany(Aktywnosc::class, 'id_leada', 'id_leada');
    }
    
    /**
     * Pobierz notatki powiązane z tym leadem.
     */
    public function notatki(): HasMany
    {
        return $this->hasMany(Notatka::class, 'id_leada', 'id_leada');
    }
}