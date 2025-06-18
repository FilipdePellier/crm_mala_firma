<?php

namespace Database\Factories;

use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition(): array
    {
        return [
            'imie' => $this->faker->firstName,
            'nazwisko' => $this->faker->lastName,
            'nazwa_firmy' => $this->faker->company,
            'email' => $this->faker->unique()->safeEmail,
            'telefon' => $this->faker->phoneNumber,
            'zrodlo' => 'Test',
            'status' => 'Nowy',
        ];
    }
}