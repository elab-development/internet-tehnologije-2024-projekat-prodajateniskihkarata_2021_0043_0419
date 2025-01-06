<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\TipKarte;
use App\Models\Dogadjaj;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TipKarte>
 */
class TipKarteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = TipKarte::class;

    public function definition(): array
    {
        return [
            'ime_tipa_karte' => $this->faker->word,
            'cena' => $this->faker->randomFloat(2, 10, 200),
            'opis_benefita' => $this->faker->paragraph,
            'broj_benefita' => $this->faker->numberBetween(1, 10),
            'dogadjaj_id' => Dogadjaj::factory(),
        ];
    }
}
