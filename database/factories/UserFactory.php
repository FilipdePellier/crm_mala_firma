<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'imie' => fake()->firstName(),
            'nazwisko' => fake()->lastName(),
            'nazwa_uzytkownika' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'haslo' => static::$password ??= Hash::make('password'),
            'rola' => 'Uzytkownik',
            'jest_aktywny' => true,
            'email_verified_at' => now(), 
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}