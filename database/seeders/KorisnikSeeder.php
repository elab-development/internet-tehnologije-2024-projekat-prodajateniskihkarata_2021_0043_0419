<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Korisnik;

class KorisnikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Korisnik::factory(10)->create();
    }
}
