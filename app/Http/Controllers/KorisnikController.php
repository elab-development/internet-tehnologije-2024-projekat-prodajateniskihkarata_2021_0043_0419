<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Korisnik;
use Illuminate\Support\Facades\Hash;

class KorisnikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Korisnik::all(), 200);
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
            'ime' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:korisniks',
            'lozinka' => 'required|string|min:8',
            'uloga' => 'required|string|in:admin,auth_user,guest',
            'datum_registracije' => 'required|date_format:Y-m-d H:i:s'
        ]);

        // Kreiranje novog korisnika
        $korisnik = Korisnik::create($validatedData);

        // Vraćanje novokreiranog korisnika sa status kodom 201
        return response()->json($korisnik, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $korisnik = Korisnik::find($id);

        if (!$korisnik) {
            return response()->json(['error' => 'Korisnik nije pronađen'], 404);
        }

        return response()->json($korisnik, 200);
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
            'ime' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:korisniks,email,' . $id,
            'lozinka' => 'sometimes|string|min:8',
            'uloga' => 'required|string|in:admin,auth_user,guest',
            'datum_registracije' => 'required|date_format:Y-m-d H:i:s'
        ]);

        // Pronalazak korisnika po ID-ju
        $korisnik = Korisnik::find($id);

        if (!$korisnik) {
            return response()->json(['error' => 'Korisnik nije pronađen'], 404);
        }

        // Ažuriranje lozinke ako je postavljena
        if (isset($validatedData['lozinka'])) {
            $validatedData['lozinka'] = Hash::make($validatedData['lozinka']);
        } else {
            unset($validatedData['lozinka']);
        }

        // Ažuriranje korisnika
        $korisnik->update($validatedData);
        return response()->json($korisnik, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $korisnik = Korisnik::find($id);

        if (!$korisnik) {
            return response()->json(['error' => 'Korisnik nije pronađen'], 404);
        }

        $korisnik->delete();
        return response()->json(null, 204);
    }

    public function promeniLozinku(Request $request, Korisnik $korisnik)
{
    $request->validate([
        'stara_lozinka' => 'required',
        'nova_lozinka' => 'required|min:8',
    ]);

    if (!Hash::check($request->stara_lozinka, $korisnik->lozinka)) {
        return response()->json(['error' => 'Stara lozinka nije ispravna'], 400);
    }

    $korisnik->lozinka = Hash::make($request->nova_lozinka);
    $korisnik->save();

    return response()->json(['message' => 'Lozinka je uspešno promenjena']);
}
}
