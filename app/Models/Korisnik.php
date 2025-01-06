<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Korisnik extends Model
{
    /** @use HasFactory<\Database\Factories\KorisnikFactory> */
    use HasFactory;

    protected $fillable = [
        'ime',
        'email',
        'lozinka',
        'uloga',
        'datum_registracije'
    ];

    protected $hidden = [
        'lozinka'
    ];

    // Mutator to hash password before saving to the database
    public function setLozinkaAttribute($value)
    {
        $this->attributes['lozinka'] = bcrypt($value);
    }

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

    public function toArray()
    {
        $array = parent::toArray();

        // Rearrange the array to the desired order
        return [
            'id' => $this->id,
            'ime' => $this->ime,
            'email' => $this->email,
            'uloga' => $this->uloga,
            'datum_registracije' => $this->datum_registracije,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
