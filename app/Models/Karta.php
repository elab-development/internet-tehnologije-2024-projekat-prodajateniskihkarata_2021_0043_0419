<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karta extends Model
{
    use HasFactory;

    protected $fillable = [
        'korisnik_id',
        'dogadjaj_id',
        'tip_karte_id',
        'status_karte',
        'qr_kod'
    ];

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

    public function toArray()
    {
        $array = parent::toArray();

        // Rearrange the array to the desired order
        return [
            'id' => $this->id,
            'korisnik_id' => $this->korisnik_id,
            'dogadjaj_id' => $this->dogadjaj_id,
            'tip_karte_id' => $this->tip_karte_id,
            'status_karte' => $this->status_karte,
            'qr_kod' => $this->qr_kod,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

}
