<?php

namespace App\Http\Controllers;

use App\Models\Dogadjaj;
use App\Models\Karta;
use App\Models\Korisnik;
use App\Models\Placanje;
use App\Models\TipKarte;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    // Primer metoda za kreiranje događaja
    public function createDogadjaj(Request $request)
    {
        // Validacija i čuvanje u bazi podataka
        $data = $request->validate([
            'ime_dogadjaja' => 'required|string|max:255',
            'lokacija' => 'required|string|max:255',
            'opis' => 'required|string',
            'status' => 'required|string',
            'datum_registracije' => 'required|date',
        ]);

        // Kreiranje događaja
        $dogadjaj = Dogadjaj::create($data);

        return response()->json(['message' => 'Događaj je uspešno kreiran', 'dogadjaj' => $dogadjaj], 201);
    }

    // Primer metoda za ažuriranje događaja
    public function updateDogadjaj(Request $request, $id)
    {
        // Validacija podataka
        $data = $request->validate([
            'ime_dogadjaja' => 'sometimes|string|max:255',
            'lokacija' => 'sometimes|string|max:255',
            'opis' => 'sometimes|string',
            'status' => 'sometimes|string',
            'datum_registracije' => 'sometimes|date',
        ]);

        // Ažuriranje događaja
        $dogadjaj = Dogadjaj::findOrFail($id);
        $dogadjaj->update($data);

        return response()->json(['message' => 'Događaj je uspešno ažuriran', 'dogadjaj' => $dogadjaj], 200);
    }

    // Primer metoda za brisanje događaja
    public function deleteDogadjaj($id)
    {
        // Brisanje događaja
        $dogadjaj = Dogadjaj::findOrFail($id);
        $dogadjaj->delete();

        return response()->json(['message' => 'Događaj je uspešno obrisan'], 200);
    }

    // Primer metoda za prikazivanje događaja
    public function showDogadjaj($id)
    {
        // Prikazivanje događaja
        $dogadjaj = Dogadjaj::findOrFail($id);

        return response()->json(['dogadjaj' => $dogadjaj], 200);
    }

    // Primer metoda za prikazivanje liste događaja
    public function indexDogadjaji()
    {
        // Prikazivanje liste događaja
        $dogadjaji = Dogadjaj::all();

        return response()->json(['dogadjaji' => $dogadjaji], 200);
    }

    // Dodatne metode za manipulaciju kartama, korisnicima, plaćanjima itd.
    // Primer metode za kreiranje karte
    public function createKarta(Request $request)
{
    try {
        // Validacija ulaznih podataka
        $data = $request->validate([
            'korisnik_id' => 'required|exists:korisniks,id',
            'dogadjaj_id' => 'required|exists:dogadjajs,id',
            'tip_karte_id' => 'required|exists:tip_kartes,id',
            'status_karte' => 'required|string',
            'qr_kod' => 'required|string|unique:kartas,qr_kod',
        ]);

        // Kreiranje nove karte
        $karta = Karta::create($data);

        // Vraćanje uspešnog odgovora
        return response()->json([
            'message' => 'Karta je uspešno kreirana',
            'karta' => $karta,
        ], 201);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Vraćanje odgovora za validacione greške
        return response()->json([
            'message' => 'Validacija nije prošla',
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        // Vraćanje odgovora za ostale greške
        return response()->json([
            'message' => 'Došlo je do neočekivane greške',
            'error' => $e->getMessage(),
        ], 500);
    }
}


    // Primer metode za prikazivanje korisnika
    public function showKorisnik($id)
    {
        // Prikazivanje korisnika
        $korisnik = Korisnik::findOrFail($id);

        return response()->json(['korisnik' => $korisnik], 200);
    }

    // Dodatne metode za manipulaciju plaćanjima, tipovima karata itd.
}