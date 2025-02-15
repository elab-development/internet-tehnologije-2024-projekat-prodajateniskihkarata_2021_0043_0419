<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TipKarte;
use App\Models\Dogadjaj;

class TipKarteFactory extends Factory
{
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
        'Final match' => [50, 75, 100, 125, 150, 200, 250],
        'Semi final match One' => [40, 50, 60, 75, 90, 125, 150],
        'Semi final match Two' => [40, 50, 60, 75, 90, 125, 150],
        'Djere L. VS Marozsan F. (Quarterfinal)' => [30, 40, 50, 60, 75, 100, 125],
        'O\'Connell C. VS Shapovalov D. (Quarterfinal)' => [30, 40, 50, 60, 75, 100, 125]
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

    // Pronađi postojeći događaj iz seedera
    $dogadjaj = Dogadjaj::inRandomOrder()->first();

    if (!$dogadjaj) {
        throw new \Exception("Nema događaja u bazi. Pokreni seeder!");
    }

    // Odaberi ime tipa karte
    $imeTipaKarte = $this->faker->randomElement($naziviTipovaKarata);

    // Izračunaj cenu ako postoji za taj događaj
    $cena = $ceneKarata[$dogadjaj->ime_dogadjaja][$this->faker->numberBetween(0, 6)] ?? 50;

    return [
        'ime_tipa_karte' => $imeTipaKarte,
        'opis_benefita' => $benefiti[$imeTipaKarte],
        'cena' => $cena,
        'broj_benefita' => $brojBenefita[$imeTipaKarte], 
        'dogadjaj_id' => $dogadjaj->id, // Poveži tip karte sa postojećim događajem
    ];
}

}
