<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Placanje;
use App\Models\Korisnik;
use App\Models\Karta;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Placanje>
 */
class PlacanjeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    protected $model = Placanje::class;

    public function definition(): array
    {
        // Kreiraj kartu
        $karta = Karta::factory()->create();

        return [
            'korisnik_id' => Korisnik::factory(),
            'iznos' => $karta->tipKarte->cena, // Postavi iznos na cenu iz tipa karte
            'datum_transakcije' => now(),
            'status_transakcije' => $this->faker->randomElement(['uspesno', 'neuspesno']),
            'tip_placanja' => $this->faker->randomElement(['kartica', 'paypal', 'gotovina']),
        ];
    }
}
