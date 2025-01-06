<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Placanje;

class PlacanjeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Placanje::factory(10)->create();
    }
}
