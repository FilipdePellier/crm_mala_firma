<?php

namespace Database\Factories;

use App\Models\Notatka;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotatkaFactory extends Factory
{
    protected $model = Notatka::class;

    public function definition(): array
    {
        return [
            'tresc_notatki' => $this->faker->paragraph,
            'utworzono_przez' => User::factory(),
            // Powiązania (id_klienta, id_leada etc.) będą ustawiane w testach
        ];
    }
}