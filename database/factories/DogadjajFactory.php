<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Dogadjaj;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dogadjaj>
 */
class DogadjajFactory extends Factory
{
    protected $model = Dogadjaj::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ime_dogadjaja' => $this->faker->sentence,
            'lokacija' => $this->faker->city,
            'opis' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['zakazan', 'odrzan', 'otkazan']),
            'datum_registracije' => now(),
        ];
    }
}
