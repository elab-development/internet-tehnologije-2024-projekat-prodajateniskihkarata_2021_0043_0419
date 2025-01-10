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

    // public function index(Request $request)
    // {
    //     $query = Dogadjaj::query();

    //     if ($request->has('status')) {
    //         $query->where('status', $request->input('status'));
    //     }

    //     return $query->paginate(10); // Paginacija sa 10 rezultata po stranici
    // }


    // GPT
    // public function index(Request $request)
    // {
    //     $query = Dogadjaj::query();

    //     // Filtriranje po imenu događaja (primer)
    //     if ($request->has('naziv')) {
    //         $query->where('naziv', 'like', '%' . $request->naziv . '%');
    //     }

    //     // Filtriranje po datumu
    //     if ($request->has('datum_od') && $request->has('datum_do')) {
    //         $query->whereBetween('datum', [$request->datum_od, $request->datum_do]);
    //     }

    //     // Paginacija (podrazumevano 10 po stranici)
    //     $dogadjaji = $query->paginate($request->get('per_page', 10));

    //     return response()->json($dogadjaji);
    // }



     // Metoda za paginaciju događaja
     public function index(Request $request)
     {
         // Dohvatanje događaja sa paginacijom
         $dogadjaji = Dogadjaj::paginate(10);
         return response()->json($dogadjaji);
     }
 
     // Metoda za filtriranje događaja
     public function filter(Request $request)
     {
         $query = Dogadjaj::query();
 
         // Filtriranje po nazivu
         if ($request->has('ime_dogadjaja')) {
             $query->where('ime_dogadjaja', 'like', '%' . $request->input('ime_dogadjaja') . '%');
         }
 
         // Filtriranje po datumu
         if ($request->has('datum')) {
             $query->whereDate('datum_registracije', $request->input('datum'));
         }
 
         $dogadjaji = $query->paginate(10);
         return response()->json($dogadjaji);
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
        // Validate the request data
        $validatedData = $request->validate([
            'ime_dogadjaja' => 'required|string|max:255',
            'lokacija' => 'required|string|max:255',
            'opis' => 'nullable|string',
            'status' => 'required|string|in:zakazan,odrzan,otkazan',
            'datum_registracije' => 'required|date_format:Y-m-d'
        ]);

        // Create a new Dogadjaj
        $dogadjaj = Dogadjaj::create($validatedData);

        // Return the created Dogadjaj with a 201 status code
        return response()->json($dogadjaj, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dogadjaj = Dogadjaj::find($id);

        if (!$dogadjaj) {
            return response()->json(['error' => 'Događaj nije pronađen'], 404);
        }

        return response()->json($dogadjaj, 200);

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
            'ime_dogadjaja' => 'required|string|max:255',
            'lokacija' => 'required|string|max:255',
            'opis' => 'nullable|string',
            'status' => 'required|string|in:zakazan,otkazan,odrzan',
            'datum_registracije' => 'required|date_format:Y-m-d'
        ]);

        // Pronalazak događaja po ID-ju
        $dogadjaj = Dogadjaj::find($id);

        if (!$dogadjaj) {
            return response()->json(['error' => 'Događaj nije pronađen'], 404);
        }

        // Ažuriranje događaja
        $dogadjaj->update($validatedData);
        return response()->json($dogadjaj, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dogadjaj = Dogadjaj::find($id);

        if (!$dogadjaj) {
            return response()->json(['error' => 'Događaj nije pronađen'], 404);
        }

        $dogadjaj->delete();
        return response()->json(null, 204);
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
