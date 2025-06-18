<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Nazwa tabeli powiązana z modelem.
     */
    protected $table = 'Uzytkownicy';

    /**
     * Klucz główny tabeli.
     */
    protected $primaryKey = 'id_uzytkownika';

    /**
     * Nazwy kolumn przechowujących daty utworzenia/aktualizacji.
     */
    const CREATED_AT = 'utworzono_at';
    const UPDATED_AT = 'zaktualizowano_at';

    /**
     * Atrybuty, które można masowo przypisywać.
     */
    protected $fillable = [
        'nazwa_uzytkownika',
        'imie',
        'nazwisko',
        'email',
        'haslo',
    ];

    /**
     * Atrybuty, które powinny być ukryte podczas serializacji.
     */
    protected $hidden = [
        'haslo',
        'remember_token',
    ];

    /**
     * Atrybuty, które powinny być rzutowane na inne typy.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'haslo' => 'hashed', 
    ];
    
    /**
     * Nadpisanie metody, aby Laravel wiedział, w której kolumnie jest hasło.
     */
    public function getAuthPassword()
    {
        return $this->haslo;
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id_uzytkownika';
    }
}