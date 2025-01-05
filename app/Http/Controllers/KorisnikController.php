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
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
