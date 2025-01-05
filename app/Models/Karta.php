<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karta extends Model
{
    public function korisnik()
    {
        return $this->belongsTo(Korisnik::class);
    }
    public function dogadjaj()
    {

        return $this->belongsTo(Dogadjaj::class);
    }
    public function tipKarte()
    {
        return $this->belongsTo(TipKarte::class);
    }
}
