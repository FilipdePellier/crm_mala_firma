<?php

namespace Database\Factories;

use App\Models\Klient;
use Illuminate\Database\Eloquent\Factories\Factory;

class KlientFactory extends Factory
{
    protected $model = Klient::class;

    public function definition(): array
    {
        return [
            'imie' => $this->faker->firstName,
            'nazwisko' => $this->faker->lastName,
            'nazwa_firmy' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'telefon' => $this->faker->phoneNumber,
        ];
    }
}