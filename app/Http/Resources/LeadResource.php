<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_leada,
            'imie' => $this->imie,
            'nazwisko' => $this->nazwisko,
            'nazwaFirmy' => $this->nazwa_firmy,
            'email' => $this->email,
            'telefon' => $this->telefon,
            'zrodlo' => $this->zrodlo,
            'status' => $this->status,
            'uwagi' => $this->uwagi,
            'dataUtworzenia' => $this->utworzono_at?->format('d-m-Y H:i'),
        ];
    }
}