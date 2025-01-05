<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dogadjaj extends Model
{
    /** @use HasFactory<\Database\Factories\DogadjajFactory> */
    use HasFactory;

    public function karte()
    {
        return $this->hasMany(Karta::class);
    }
    public function tipoviKarata()
    {
        return $this->hasMany(TipKarte::class);
    }
}
