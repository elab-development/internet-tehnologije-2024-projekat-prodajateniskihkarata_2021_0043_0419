<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Placanje;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PlacanjeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Placanje::all(), 200);
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
                 'korisnik_id' => 'required|exists:korisniks,id',
                 'iznos' => 'required|numeric',
                 'datum_transakcije' => 'required|date_format:Y-m-d H:i:s',
                 'status_transakcije' => 'required|string|max:255',
                 'tip_placanja' => 'required|string|max:255'
             ]);
     
             // Kreiranje novog plaćanja
             $placanje = Placanje::create($validatedData);
     
             // Vraćanje novokreiranog plaćanja sa status kodom 201
             return response()->json([
                 'message' => 'Plaćanje je uspešno kreirano',
                 'placanje' => $placanje,
             ], 201);
         } catch (\Illuminate\Validation\ValidationException $e) {
             // Obrada validacionih grešaka
             return response()->json([
                 'message' => 'Validacija nije prošla',
                 'errors' => $e->errors(),
             ], 422);
         } catch (\Exception $e) {
             // Obrada neočekivanih grešaka
             Log::error('Greška pri kreiranju plaćanja: ' . $e->getMessage(), [
                 'trace' => $e->getTraceAsString()
             ]);
     
             return response()->json([
                 'message' => 'Došlo je do neočekivane greške',
                 'error' => $e->getMessage(),
             ], 500);
         }
     }

//sr
    // public function store(Request $request)
    // {
    //     // Proveri da li je korisnik ulogovan
    //     if (!Auth::check()) {
    //         return response()->json(['error' => 'Korisnik nije ulogovan.'], 401);
    //     }

    //     // Validacija podataka iz zahteva
    //     $validatedData = $request->validate([
    //         'korisnik_id' => 'required|exists:korisniks,id',
    //         'iznos' => 'required|numeric',
    //         'datum_transakcije' => 'required|date_format:Y-m-d H:i:s',
    //         'status_transakcije' => 'required|string|max:255',
    //         'tip_placanja' => 'required|string|max:255'
    //     ]);

    //     try {
    //         // Kreiranje novog plaćanja
    //         $placanje = Placanje::create($validatedData);

    //         return response()->json($placanje, 201);
    //     } catch (\Exception $e) {
    //         // U slučaju greške pri kreiranju
    //         return response()->json(['error' => 'Greška prilikom kreiranja plaćanja: ' . $e->getMessage()], 500);
    //     }
    // }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $placanje = Placanje::find($id);

        if (!$placanje) {
            return response()->json(['error' => 'Plaćanje nije pronađeno'], 404);
        }

        return response()->json($placanje, 200);
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
        // Proveri da li je korisnik ulogovan
        if (!Auth::check()) {
            return response()->json(['error' => 'Korisnik nije ulogovan.'], 401);
        }

        // Validacija podataka iz zahteva
        $validatedData = $request->validate([
            'korisnik_id' => 'required|exists:korisniks,id',
            'iznos' => 'required|numeric',
            'datum_transakcije' => 'required|date_format:Y-m-d H:i:s',
            'status_transakcije' => 'required|string|max:255',
            'tip_placanja' => 'required|string|max:255'
        ]);

        // Pronalazak plaćanja po ID-ju
        $placanje = Placanje::find($id);

        if (!$placanje) {
            return response()->json(['error' => 'Plaćanje nije pronađeno'], 404);
        }

        // Ažuriranje plaćanja
        $placanje->update($validatedData);
        return response()->json($placanje, 200);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Proveri da li je korisnik ulogovan
        if (!Auth::check()) {
            return response()->json(['error' => 'Korisnik nije ulogovan.'], 401);
        }

        $placanje = Placanje::find($id);

        if (!$placanje) {
            return response()->json(['error' => 'Plaćanje nije pronađeno'], 404);
        }

        $placanje->delete();
        return response()->json(null, 204);
    }
}