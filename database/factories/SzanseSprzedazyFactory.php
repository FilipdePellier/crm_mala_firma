<?php

namespace Database\Factories;

use App\Models\SzanseSprzedazy;
use App\Models\Klient;
use App\Models\Kontakt;
use Illuminate\Database\Eloquent\Factories\Factory;

class SzanseSprzedazyFactory extends Factory
{
    protected $model = SzanseSprzedazy::class;

    public function definition(): array
    {
        return [
            'id_klienta' => Klient::factory(),
            'id_kontaktu' => Kontakt::factory(),
            'nazwa' => 'Testowa szansa sprzedaży',
            'etap' => 'Kwalifikacja',
            'wartosc' => $this->faker->randomFloat(2, 1000, 50000),
            'data_zamkniecia' => $this->faker->dateTimeBetween('+1 month', '+6 months'),
        ];
    }
}