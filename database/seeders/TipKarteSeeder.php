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
    }
}
