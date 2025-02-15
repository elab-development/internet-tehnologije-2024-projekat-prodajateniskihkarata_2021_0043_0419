<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Korisnik;
use Illuminate\Support\Facades\Hash;

class KorisnikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Generisanje 10 random korisnika
        Korisnik::factory(10)->create();

        // Dodavanje dva specifična korisnika
        Korisnik::create([
            'ime' => 'Admin',
            'email' => 'admin@admin.com',
            'lozinka' => 'asd123A!',
            'uloga' => 'admin',
            'datum_registracije' => now(),
        ]);

        Korisnik::create([
            'ime' => 'Brzi Sreten',
            'email' => 'brzovozi8@gmail.com',
            'lozinka' => 'asd123A!',
            'uloga' => 'auth_user',
            'datum_registracije' => now(),
        ]);
    }
}

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
