<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Karta;
use App\Models\Dogadjaj;
use App\Models\TipKarte;
use App\Models\Korisnik;

class KartaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Karta::factory(10)->create();

        // $dogadjaji = Dogadjaj::all();
        // $tipoviKarata = TipKarte::all();

        // $dogadjaji->each(function ($dogadjaj) use ($tipoviKarata) {
        //     $tipoviKarata->each(function ($tipKarte) use ($dogadjaj) {
        //         Karta::factory()->create([
        //             'dogadjaj_id' => $dogadjaj->id,
        //             'tip_karte_id' => $tipKarte->id,
        //             'korisnik_id' => Korisnik::factory()->create()->id,
        //         ]);
        //     });
        // });

    }
}
