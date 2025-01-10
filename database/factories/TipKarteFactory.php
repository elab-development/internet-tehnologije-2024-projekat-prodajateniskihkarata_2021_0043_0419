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
        $naziviTipovaKarata = [
            'tribina', 'parter', 'balkon', 'prvi red', 'loža', 'VIP loža', 'VIP salon'
        ];

        $benefiti = [
            'tribina' => '- Pristup opštim sedištima sa dobrim pregledom terena.',
            'parter' => '- Pristup bližim sedištima bliže terenu za bolji doživljaj meča.',
            'balkon' => '- Sedišta sa povišenim pogledom i boljom perspektivom na ceo teren.',
            'prvi red' => '- Ekskluzivna sedišta u prvom redu sa najbližim pogledom na teren.',
            'loža' => '- Privatna sedišta u loži sa udobnijim nameštajem.',
            'VIP loža' => '- Privatna loža sa dodatnim benefitima:\n- Besplatan švedski sto i piće.\n- Posebni ulazi za brži pristup stadionu.',
            'VIP salon' => '- Najprestižniji paket:\n- Privatni salon sa ekskluzivnim ugostiteljstvom (hrana i piće vrhunskog kvaliteta).\n- Pristup after-party događajima sa igračima (za polufinale i finale).\n- Služba domaćina koja pruža personalizovanu uslugu tokom događaja.\n- VIP parking mesto u neposrednoj blizini stadiona.'
        ];

        $ceneKarata = [
            'kvalifikacioni meč' => [10, 15, 20, 25, 30, 40, 50],
            'grupna faza' => [15, 20, 25, 35, 45, 60, 75],
            'osmina finala' => [20, 25, 30, 40, 55, 75, 100],
            'četvrt finale' => [30, 40, 50, 60, 75, 100, 125],
            'polu finale' => [40, 50, 60, 75, 90, 125, 150],
            'finale' => [50, 75, 100, 125, 150, 200, 250]
        ];

        $brojBenefita = [
            'tribina' => 1,
            'parter' => 1,
            'balkon' => 1,
            'prvi red' => 1,
            'loža' => 2,
            'VIP loža' => 3,
            'VIP salon' => 5
        ];

        // Kreiraj događaj
        $dogadjaj = Dogadjaj::factory()->create();

        // Odaberi ime tipa karte
        $imeTipaKarte = $this->faker->randomElement($naziviTipovaKarata);

        // Mapa tipova karata
        $tipoviKarata = [
            'tribina' => 0, 'parter' => 1, 'balkon' => 2, 'prvi red' => 3,
            'loža' => 4, 'VIP loža' => 5, 'VIP salon' => 6
        ];

        // Izračunaj cenu na osnovu naziva događaja i tipa karte
        $cena = $ceneKarata[$dogadjaj->ime_dogadjaja][$tipoviKarata[$imeTipaKarte]];

        return [
            'ime_tipa_karte' => $imeTipaKarte,
            'opis_benefita' => $benefiti[$imeTipaKarte],
            'cena' => $cena,
            'broj_benefita' => $brojBenefita[$imeTipaKarte], // Dodaj broj benefita prema tipu karte
            'dogadjaj_id' => $dogadjaj->id, // Poveži tip karte sa događajem
        ];


        // return [
        //     'ime_tipa_karte' => $this->faker->word,
        //     'cena' => $this->faker->randomFloat(2, 10, 200),
        //     'opis_benefita' => $this->faker->paragraph,
        //     'broj_benefita' => $this->faker->numberBetween(1, 10),
        //     'dogadjaj_id' => Dogadjaj::factory(),
        // ];
    }
}
