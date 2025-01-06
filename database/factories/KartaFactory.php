<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Karta;
use App\Models\Korisnik;
use App\Models\Dogadjaj;
use App\Models\TipKarte;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Karta>
 */
class KartaFactory extends Factory
{
    protected $model = Karta::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'korisnik_id' => Korisnik::factory(),
            'dogadjaj_id' => Dogadjaj::factory(),
            'tip_karte_id' => TipKarte::factory(),
            'status_karte' => $this->faker->randomElement(['validna', 'iskoriscena', 'otkazana']),
            'qr_kod' => $this->faker->uuid,
        ];
    }
}
