<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Karta;
use App\Models\Korisnik;

use App\Models\Placanje;

class PlacanjeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Placanje::factory(10)->create();

    //    Placanje::factory(10)->create([
    //     'karta_id' => Karta::factory(),
    //     'korisnik_id' => Korisnik::factory(),
    // ]);
    }
}
