<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TipKarte;

class TipKarteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TipKarte::factory(10)->create();

        // $naziviTipovaKarata = [
        //     'tribina',
        //     'parter',
        //     'balkon',
        //     'prvi red',
        //     'loža',
        //     'VIP loža',
        //     'VIP salon'
        // ];

        // $benefiti = [
        //     'tribina' => '- Pristup opštim sedištima sa dobrim pregledom terena.',
        //     'parter' => '- Pristup bližim sedištima bliže terenu za bolji doživljaj meča.',
        //     'balkon' => '- Sedišta sa povišenim pogledom i boljom perspektivom na ceo teren.',
        //     'prvi red' => '- Ekskluzivna sedišta u prvom redu sa najbližim pogledom na teren.',
        //     'loža' => '- Privatna sedišta u loži sa udobnijim nameštajem.',
        //     'VIP loža' => '- Privatna loža sa dodatnim benefitima:\n- Besplatan švedski sto i piće.\n- Posebni ulazi za brži pristup stadionu.',
        //     'VIP salon' => '- Najprestižniji paket:\n- Privatni salon sa ekskluzivnim ugostiteljstvom (hrana i piće vrhunskog kvaliteta).\n- Pristup after-party događajima sa igračima (za polufinale i finale).\n- Služba domaćina koja pruža personalizovanu uslugu tokom događaja.\n- VIP parking mesto u neposrednoj blizini stadiona.'
        // ];

        // foreach ($naziviTipovaKarata as $naziv) {
        //     TipKarte::factory()->create([
        //         'ime_tipa_karte' => $naziv,
        //         'opis_benefita' => $benefiti[$naziv],
        //     ]);
        // }
    }
}