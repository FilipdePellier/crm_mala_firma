<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SzanseSprzedazyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id_szansy,
            'nazwa' => $this->nazwa,
            'etap' => $this->etap,
            'wartosc' => $this->wartosc,
            'dataZamkniecia' => $this->data_zamkniecia?->format('d-m-Y'),
            'opis' => $this->opis,
            'klient' => new KlientResource($this->whenLoaded('klient')),
            'kontakt' => new KontaktResource($this->whenLoaded('kontakt')),
            'dataUtworzenia' => $this->utworzono_at?->format('d-m-Y H:i'),
        ];
    }
}