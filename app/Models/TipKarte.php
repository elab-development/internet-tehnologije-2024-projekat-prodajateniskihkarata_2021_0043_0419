<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipKarte extends Model
{
    /** @use HasFactory<\Database\Factories\TipKarteFactory> */
    use HasFactory;

    protected $fillable = [
        'ime_tipa_karte',
        'cena',
        'opis_benefita',
        'broj_benefita',
        'dogadjaj_id'
    ];

    public function karte()
    {
        return $this->hasMany(Karta::class);
    }
    public function dogadjaj()
    {
        return $this->belongsTo(Dogadjaj::class);
    }

    public function toArray()
    {
        $array = parent::toArray();

        // Rearrange the array to the desired order
        return [
            'id' => $this->id,
            'ime_tipa_karte' => $this->ime_tipa_karte,
            'cena' => $this->cena,
            'opis_benefita' => $this->opis_benefita,
            'broj_benefita' => $this->broj_benefita,
            'dogadjaj_id' => $this->dogadjaj_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
