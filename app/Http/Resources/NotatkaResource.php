<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotatkaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_notatki,
            'tresc' => $this->tresc_notatki,
            'utworzonoPrzez' => $this->uzytkownik->imie . ' ' . $this->uzytkownik->nazwisko,
            'idUzytkownika' => $this->utworzono_przez,
            'powiazanie' => [
                'klientId' => $this->id_klienta,
                'leadId' => $this->id_leada,
                'szansaId' => $this->id_szansy,
                'kontaktId' => $this->id_kontaktu,
            ],
            'dataUtworzenia' => $this->utworzono_at?->format('d-m-Y H:i'),
        ];
    }
}