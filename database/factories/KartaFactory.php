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

        // $ceneKarata = [
        //     'kvalifikacioni meč' => [10, 15, 20, 25, 30, 40, 50],
        //     'grupna faza' => [15, 20, 25, 35, 45, 60, 75],
        //     'osmina finala' => [20, 25, 30, 40, 55, 75, 100],
        //     'četvrt finale' => [30, 40, 50, 60, 75, 100, 125],
        //     'polu finale' => [40, 50, 60, 75, 90, 125, 150],
        //     'finale' => [50, 75, 100, 125, 150, 200, 250]
        // ];

        $tipoviKarata = [
            'tribina' => 0, 'parter' => 1, 'balkon' => 2, 'prvi red' => 3,
            'loža' => 4, 'VIP loža' => 5, 'VIP salon' => 6
        ];

        $dogadjaj = Dogadjaj::factory()->create();
        $tipKarte = TipKarte::factory()->create();

        // Izračunaj cenu na osnovu naziva događaja i tipa karte
        //$cena = $ceneKarata[$dogadjaj->ime_dogadjaja][$tipoviKarata[$tipKarte->ime_tipa_karte]];

        return [
            'korisnik_id' => Korisnik::factory(),
            'dogadjaj_id' => $dogadjaj->id,
            'tip_karte_id' => $tipKarte->id,
            'status_karte' => $this->faker->randomElement(['validna', 'iskoriscena', 'otkazana']),
            'qr_kod' => $this->faker->uuid,
            //$cena = $ceneKarata[$dogadjaj->ime_dogadjaja][$tipoviKarata[$tipKarte->ime_tipa_karte]];

        ];


        // return [
        //     'korisnik_id' => Korisnik::factory(),
        //     'dogadjaj_id' => Dogadjaj::factory(),
        //     'tip_karte_id' => TipKarte::factory(),
        //     'status_karte' => $this->faker->randomElement(['validna', 'iskoriscena', 'otkazana']),
        //     'qr_kod' => $this->faker->uuid,
        // ];
    }
}
