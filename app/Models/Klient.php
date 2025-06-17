<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Klient extends Model
{
    use HasFactory;

    protected $table = 'Klienci';
    protected $primaryKey = 'id_klienta';
    const CREATED_AT = 'utworzono_at';
    const UPDATED_AT = 'zaktualizowano_at';

    protected $fillable = [
        'imie',
        'nazwisko',
        'nazwa_firmy',
        'email',
        'telefon',
        'adres',
        'miasto',
        'wojewodztwo',
        'kod_pocztowy',
        'kraj',
    ];

    public function getRouteKeyName()
    {
        return 'id_klienta';
    }
}