<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Korisnik extends Model
{
    /** @use HasFactory<\Database\Factories\KorisnikFactory> */
    use HasFactory;

    const ADMIN = 'admin';
    const AUTH_USER = 'auth_user';
    const GUEST = 'guest';

    public function karte()
    {
        return $this->hasMany(Karta::class);
    }
    public function placanja()
    {
        return $this->hasMany(Placanje::class);
    }
}
