<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Placanje;
use App\Models\Korisnik;

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
        return [
            'korisnik_id' => Korisnik::factory(),
            'iznos' => $this->faker->randomFloat(2, 10, 200),
            'datum_transakcije' => now(),
            'status_transakcije' => $this->faker->randomElement(['uspesno', 'neuspesno']),
            'tip_placanja' => $this->faker->randomElement(['kartica', 'paypal', 'gotovina']),
        ];
    }
}
