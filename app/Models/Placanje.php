<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Placanje extends Model
{
    /** @use HasFactory<\Database\Factories\PlacanjeFactory> */
    use HasFactory;

    public function korisnik()
    {
        return $this->belongsTo(Korisnik::class);
    }
}
