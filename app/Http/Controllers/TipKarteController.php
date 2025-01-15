<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipKarte;
use App\Models\Placanje;

class TipKarteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    if (!auth()->check()) { // Provera da li je korisnik ulogovan
        return response()->json([
            'error' => 'Unauthorized',
            'message' => 'Morate biti ulogovani da biste pristupili ovom resursu.'
        ], 401);
    }

    return response()->json(TipKarte::all(), 200);
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

     public function store(Request $request)
{
    try {
        // Validacija podataka iz zahteva
        $validatedData = $request->validate([
            'ime_tipa_karte' => 'required|string|max:255',
            'cena' => 'required|numeric',
            'opis_benefita' => 'required|string',
            'broj_benefita' => 'required|integer',
            'dogadjaj_id' => 'required|exists:dogadjajs,id',
        ]);

        // Kreiranje novog tipa karte
        $tipKarte = TipKarte::create($validatedData);

        // Vraćanje odgovora
        return response()->json($tipKarte, 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Vraćanje JSON odgovora za greške u validaciji
        return response()->json([
            'error' => 'Validacija nije uspela.',
            'message' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        // Vraćanje JSON odgovora za sve ostale greške
        return response()->json([
            'error' => 'Došlo je do greške.',
            'message' => $e->getMessage(),
        ], 500);
    }
}


//sr
    // public function store(Request $request)
    // {

    //     if (!auth()->check()) {
    //         return response()->json([
    //             'error' => 'Unauthorized',
    //             'message' => 'Morate biti ulogovani da biste kreirali tip karte.'
    //         ], 401);
    //     }
    //     // Validacija podataka iz zahteva
    //     $validatedData = $request->validate([
    //         'ime_tipa_karte' => 'required|string|max:255',
    //         'cena' => 'required|numeric',
    //         'opis_benefita' => 'required|string',
    //         'broj_benefita' => 'required|integer',
    //         'dogadjaj_id' => 'required|exists:dogadjajs,id'
    //     ]);

    //     // Kreiranje novog tipa karte
    //     $tipKarte = TipKarte::create($validatedData);

    //     // Vraćanje odgovora
    //     return response()->json($tipKarte, 201);
    // }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $tipKarte = TipKarte::find($id);

        if (!$tipKarte) {
            return response()->json([
                'error' => 'Not Found',
                'message' => 'Tip karte nije pronađen.'
            ], 404);
        }

        return response()->json($tipKarte, 200);
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
            'ime_tipa_karte' => 'required|string|max:255',
            'cena' => 'required|numeric',
            'opis_benefita' => 'required|string',
            'broj_benefita' => 'required|integer',
            'dogadjaj_id' => 'required|exists:dogadjajs,id'
        ]);

        // Pronalazak tipa karte po ID-ju
        $tipKarte = TipKarte::find($id);

        if (!$tipKarte) {
            return response()->json(['error' => 'Tip karte nije pronađen'], 404);
        }

        // Ažuriranje tipa karte
        $tipKarte->update($validatedData);

        // Vraćanje odgovora
        return response()->json($tipKarte, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $tipKarte = TipKarte::find($id);

        if (!$tipKarte) {
            return response()->json(['error' => 'Tip karte nije pronađen'], 404);
        }

        $tipKarte->delete();
        return response()->json(null, 204);
    }
}