<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Placanje extends Model
{
    /** @use HasFactory<\Database\Factories\PlacanjeFactory> */
    use HasFactory;

    protected $fillable = [
        'korisnik_id',
        'iznos',
        'datum_transakcije',
        'status_transakcije',
        'tip_placanja'
    ];

    public function korisnik()
    {
        return $this->belongsTo(Korisnik::class);
    }

    public function toArray()
    {
        $array = parent::toArray();

        // Rearrange the array to the desired order
        return [
            'id' => $this->id,
            'korisnik_id' => $this->korisnik_id,
            'iznos' => $this->iznos,
            'datum_transakcije' => $this->datum_transakcije,
            'status_transakcije' => $this->status_transakcije,
            'tip_placanja' => $this->tip_placanja,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
