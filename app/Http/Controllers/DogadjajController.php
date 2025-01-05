<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dogadjaj;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;

class DogadjajController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Dogadjaj::query();

        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        return $query->paginate(10); // Paginacija sa 10 rezultata po stranici
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
    public function fetchExternalData()
    {
        $response = Http::get('https://api.example.com/data');

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Failed to fetch data'], 500);
    }
    public function export()
    {
        $dogadjaji = Dogadjaj::all();
        $csv = "ID, Ime Dogadjaja, Lokacija, Opis, Status, Datum Registracije\n";

        foreach ($dogadjaji as $dogadjaj) {
            $csv .= "{$dogadjaj->id}, \"{$dogadjaj->ime_dogadjaja}\", \"{$dogadjaj->lokacija}\", \"{$dogadjaj->opis}\", \"{$dogadjaj->status}\", \"{$dogadjaj->datum_registracije}\"\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="dogadjaji.csv"',
        ]);
    }
}
