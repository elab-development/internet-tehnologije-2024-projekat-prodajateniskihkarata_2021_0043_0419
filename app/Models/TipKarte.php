<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipKarte extends Model
{
    /** @use HasFactory<\Database\Factories\TipKarteFactory> */
    use HasFactory;

    public function karte()
    {
        return $this->hasMany(Karta::class);
    }
    public function dogadjaj()
    {
        return $this->belongsTo(Dogadjaj::class);
    }
}
