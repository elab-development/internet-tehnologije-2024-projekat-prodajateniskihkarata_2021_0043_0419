<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Korisnik;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Korisnik>
 */
class KorisnikFactory extends Factory
{
    protected $model = Korisnik::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ime' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'lozinka' => Hash::make('password'), // Lozinka će biti 'password'
            'uloga' => $this->faker->randomElement([Korisnik::ADMIN, Korisnik::AUTH_USER, Korisnik::GUEST]),
            'datum_registracije' => now(),
        ];
    }
}
