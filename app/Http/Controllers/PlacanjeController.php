<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Placanje;

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
        return response()->json($placanje, 201);
    }
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
        $placanje = Placanje::find($id);

        if (!$placanje) {
            return response()->json(['error' => 'Plaćanje nije pronađeno'], 404);
        }

        $placanje->delete();
        return response()->json(null, 204);
    }
}
