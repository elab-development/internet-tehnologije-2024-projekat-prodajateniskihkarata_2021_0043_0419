<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dogadjaj extends Model
{
    /** @use HasFactory<\Database\Factories\DogadjajFactory> */
    use HasFactory;

    protected $fillable = [
        'ime_dogadjaja',
        'lokacija',
        'opis',
        'status',
        'datum_registracije'
    ];

    public function karte()
    {
        return $this->hasMany(Karta::class);
    }
    public function tipoviKarata()
    {
        return $this->hasMany(TipKarte::class);
    }

    public function toArray()
    {
        $array = parent::toArray();

        // Rearrange the array to the desired order
        return [
            'id' => $this->id,
            'ime_dogadjaja' => $this->ime_dogadjaja,
            'lokacija' => $this->lokacija,
            'opis' => $this->opis,
            'status' => $this->status,
            'datum_registracije' => $this->datum_registracije,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    // Scope za pretragu po nazivu događaja
    public function scopeNaziv($query, $naziv)
    {
        if ($naziv) {
            return $query->where('ime_dogadjaja', 'LIKE', "%$naziv%");
        }
        return $query;
    }

    // Scope za pretragu po lokaciji
    public function scopeLokacija($query, $lokacija)
    {
        if ($lokacija) {
            return $query->where('lokacija', 'LIKE', "%$lokacija%");
        }
        return $query;
    }

    // Scope za pretragu po statusu
    public function scopeStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }

}
