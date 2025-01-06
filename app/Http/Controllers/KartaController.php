<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Karta;
use Illuminate\Support\Facades\Log;

class KartaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Karta::all(), 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     // Validacija podataka iz zahteva
    //     $validatedData = $request->validate([
    //         'korisnik_id' => 'required|exists:korisniks,id',
    //         'dogadjaj_id' => 'required|exists:dogadjajs,id',
    //         'tip_karte_id' => 'required|exists:tip_kartes,id',
    //         'status_karte' => 'required|string|in:validna,proverena,nevalidna',
    //         'qr_kod' => 'required|string|max:255|unique:kartas,qr_kod'
    //     ]);

    //     // Kreiranje nove karte
    //     $karta = Karta::create($validatedData);

    //     // Vraćanje odgovora
    //     return response()->json($karta, 201);
    // }

    public function store(Request $request)
    {
        // Logovanje dolaznog zahteva
        Log::info('Primljen POST zahtev za kreiranje karte', $request->all());

        // Validacija podataka iz zahteva
        $validatedData = $request->validate([
            'korisnik_id' => 'required|exists:korisniks,id',
            'dogadjaj_id' => 'required|exists:dogadjajs,id',
            'tip_karte_id' => 'required|exists:tip_kartes,id',
            'status_karte' => 'required|string|in:validna,proverena,nevalidna',
            'qr_kod' => 'required|string|max:255|unique:kartas,qr_kod'
        ]);

        // Logovanje validiranih podataka
        Log::info('Validirani podaci za kreiranje karte', $validatedData);

        // Kreiranje nove karte
        $karta = Karta::create($validatedData);

        // Logovanje kreirane karte
        Log::info('Kreirana karta', $karta->toArray());

        // Vraćanje odgovora
        return response()->json($karta, 201);
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $karta = Karta::find($id);

        if (!$karta) {
            return response()->json(['error' => 'Karta nije pronađena'], 404);
        }

        return response()->json($karta, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, $id)
    {
        // Validacija podataka iz zahteva
        $validatedData = $request->validate([
            'korisnik_id' => 'required|exists:korisniks,id',
            'dogadjaj_id' => 'required|exists:dogadjajs,id',
            'tip_karte_id' => 'required|exists:tip_kartes,id',
            'status_karte' => 'required|string|in:validna,proverena,nevalidna',
            'qr_kod' => 'required|string|max:255|unique:kartas,qr_kod,' . $id
        ]);

        // Pronalazak karte po ID-ju
        $karta = Karta::find($id);

        if (!$karta) {
            return response()->json(['error' => 'Karta nije pronađena'], 404);
        }

        // Ažuriranje karte
        $karta->update($validatedData);
        return response()->json($karta, 200);
    }

    // public function update(Request $request, $id)
    // {
    //     // Validacija podataka iz zahteva
    //     $validatedData = $request->validate([
    //         'korisnik_id' => 'required|exists:korisniks,id',
    //         'dogadjaj_id' => 'required|exists:dogadjajs,id',
    //         'tip_karte_id' => 'required|exists:tip_kartes,id',
    //         'status_karte' => 'required|string|in:validna,proverena,nevalidna',
    //         'qr_kod' => 'required|string|max:255|unique:kartas,qr_kod,' . $id
    //     ]);

    //     // Pronalazak karte po ID-ju
    //     $karta = Karta::find($id);

    //     if (!$karta) {
    //         return response()->json(['error' => 'Karta nije pronađena'], 404);
    //     }

    //     // Ažuriranje karte
    //     $karta->update($validatedData);

    //     // Vraćanje odgovora
    //     return response()->json($karta, 200);
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $karta = Karta::find($id);

        if (!$karta) {
            return response()->json(['error' => 'Karta nije pronađena'], 404);
        }

        $karta->delete();
        return response()->json(null, 204);
    }
}
