<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class KlientResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id_klienta,
            'pelneImie' => $this->imie . ' ' . $this->nazwisko,
            'firma' => $this->nazwa_firmy,
            'kontakt' => [
                'email' => $this->email,
                'telefon' => $this->telefon,
            ],
            'adres' => $this->adres . ', ' . $this->kod_pocztowy . ' ' . $this->miasto,
            'kraj' => $this->kraj,
            'dataUtworzenia' => $this->utworzono_at?->format('d-m-Y H:i'),
        ];
    }
}