<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Karta;

class KartaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Karta::factory(10)->create();
    }
}
