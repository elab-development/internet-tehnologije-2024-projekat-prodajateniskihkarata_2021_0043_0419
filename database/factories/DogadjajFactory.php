<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Dogadjaj;

class DogadjajFactory extends Factory
{
    protected $model = Dogadjaj::class;

    public function definition(): array
    {
        return [
            'ime_dogadjaja' => 'Qualification match',  // Postavi fiksni naziv događaja
            'lokacija' => 'Belgrade Arena', // Fiksna lokacija
            'opis' => 'Qualifications',  // Fiksni opis
            'status' => 'Postponed', // Fiksni status
            'datum_registracije' => now(),
        ];
    }
}
