<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KontaktResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_kontaktu,
            'idKlienta' => $this->id_klienta,
            'imie' => $this->imie,
            'nazwisko' => $this->nazwisko,
            'pelneImie' => $this->imie . ' ' . $this->nazwisko,
            'stanowisko' => $this->stanowisko,
            'email' => $this->email,
            'telefon' => $this->telefon,
            'dataUtworzenia' => $this->utworzono_at?->format('d-m-Y H:i'),
        ];
    }
}