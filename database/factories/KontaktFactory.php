<?php

namespace Database\Factories;

use App\Models\Kontakt;
use App\Models\Klient;
use Illuminate\Database\Eloquent\Factories\Factory;

class KontaktFactory extends Factory
{
    protected $model = Kontakt::class;

    public function definition(): array
    {
        return [
            'id_klienta' => Klient::factory(), 
            'imie' => $this->faker->firstName,
            'nazwisko' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}