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
        $naziviDogadjaja = [
            'kvalifikacioni meč', 'grupna faza', 'osmina finala',
            'četvrt finale', 'polu finale', 'finale'
        ];

        $opisiDogadjaja = [
            'kvalifikacioni meč' => 'kvalifikacioni meč',
            'grupna faza' => 'grupni meč',
            'osmina finala' => 'meč osmine finala',
            'četvrt finale' => 'četvrt finalni meč',
            'polu finale' => 'polufinalni meč',
            'finale' => 'finalni meč'
        ];

        $naziv = $this->faker->randomElement($naziviDogadjaja);
        $opis = $opisiDogadjaja[$naziv];
        $lokacije = ['Beogradska arena', 'hala 1'];

        return [
            'ime_dogadjaja' => $naziv,
            'lokacija' => $this->faker->randomElement($lokacije),
            'opis' => $opis,
            'status' => $this->faker->randomElement(['zakazan', 'odrzan', 'otkazan']),
            'datum_registracije' => now(),
        ];

        // return [
        //     'ime_dogadjaja' => $this->faker->sentence,
        //     'lokacija' => $this->faker->city,
        //     'opis' => $this->faker->paragraph,
        //     'status' => $this->faker->randomElement(['zakazan', 'odrzan', 'otkazan']),
        //     'datum_registracije' => now(),
        // ];
    }
}
