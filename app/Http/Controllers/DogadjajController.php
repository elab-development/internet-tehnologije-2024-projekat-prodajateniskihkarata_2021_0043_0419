<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dogadjaj;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

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

    // Metoda za paginaciju i filtriranje događaja
    // public function index(Request $request)
    // {
    //     $query = Dogadjaj::query();

    //     // Filtriranje po nazivu
    //     if ($request->has('ime_dogadjaja')) {
    //         $query->where('ime_dogadjaja', 'like', '%' . $request->input('ime_dogadjaja') . '%');
    //     }

    //     // Filtriranje po datumu
    //     if ($request->has('datum')) {
    //         $query->whereDate('datum_registracije', $request->input('datum'));
    //     }

    //     // Paginacija
    //     $dogadjaji = $query->paginate($request->input('per_page', 10));

    //     return response()->json($dogadjaji);
    // }

    // Paginacija i filtriranje događaja
    //  public function index(Request $request)
    //  {
    //      try {
    //          $query = Dogadjaj::query();

    //          // Filtriranje po nazivu
    //          if ($request->has('ime_dogadjaja')) {
    //              $query->where('ime_dogadjaja', 'like', '%' . $request->input('ime_dogadjaja') . '%');
    //          }

    //          // Filtriranje po datumu
    //          if ($request->has('datum')) {
    //              $query->whereDate('datum_registracije', $request->input('datum'));
    //          }

    //          // Sortiranje (opciono)
    //          if ($request->has('sort_by')) {
    //              $sortBy = $request->input('sort_by');
    //              $sortOrder = $request->input('sort_order', 'asc'); // Uzlazno sortiranje kao podrazumevano
    //              $query->orderBy($sortBy, $sortOrder);
    //          }

    //          // Paginacija
    //          $dogadjaji = $query->paginate(10);

    //          return response()->json([
    //              'success' => true,
    //              'data' => $dogadjaji,
    //              'message' => 'Događaji uspešno dobijeni.',
    //          ]);

    //      } catch (\Exception $e) {
    //          return response()->json([
    //              'success' => false,
    //              'message' => 'Došlo je do greške: ' . $e->getMessage(),
    //          ], 500);
    //      }
    //  }

    // Metoda za paginaciju događaja
    public function index(Request $request)
    {
        try {
            // Dohvatanje događaja sa paginacijom
            $dogadjaji = Dogadjaj::paginate(10);
            return response()->json($dogadjaji);
        } catch (\Exception $e) {
            // Logovanje greške
            Log::error('Greška u index metodi: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            // Hvatanje greške
            return response()->json(['error' => 'Došlo je do greške: ' . $e->getMessage()], 500);
        }
    }

    public function filter(Request $request)
    {
        try {
            $query = Dogadjaj::query();

            if ($request->has('ime_dogadjaja')) {
                $query->where('ime_dogadjaja', 'like', '%' . $request->input('ime_dogadjaja') . '%');
            }

            if ($request->has('datum')) {
                $query->whereDate('datum_registracije', $request->input('datum'));
            }

            $dogadjaji = $query->paginate(10);
            return response()->json($dogadjaji); // Ovo forsira JSON odgovor
        } catch (\Exception $e) {
            Log::error('Greška u filter metodi: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return response()->json(['error' => 'Došlo je do greške: ' . $e->getMessage()], 500);
        }
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
            // Validacija ulaznih podataka
            $validatedData = $request->validate([
                'ime_dogadjaja' => 'required|string|max:255',
                'lokacija' => 'required|string|max:255',
                'opis' => 'nullable|string',
                'status' => 'required|string|in:zakazan,odrzan,otkazan',
                'datum_registracije' => 'required|date_format:Y-m-d'
            ]);

            // Kreiranje novog Dogadjaja
            $dogadjaj = Dogadjaj::create($validatedData);

            // Vraćanje uspešnog odgovora sa statusnim kodom 201
            return response()->json([
                'message' => 'Događaj je uspešno kreiran',
                'dogadjaj' => $dogadjaj
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Obrada validacionih grešaka
            return response()->json([
                'message' => 'Validacija nije prošla',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Obrada neočekivanih grešaka
            return response()->json([
                'message' => 'Došlo je do neočekivane greške',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    // sr
    // public function store(Request $request)
    // {
    //     try {
    //         // Validacija podataka
    //         $validatedData = $request->validate([
    //             'ime_dogadjaja' => 'required|string|max:255',
    //             'lokacija' => 'required|string|max:255',
    //             'opis' => 'nullable|string',
    //             'status' => 'required|string|in:zakazan,odrzan,otkazan',
    //             'datum_registracije' => 'required|date_format:Y-m-d'
    //         ]);

    //         // Kreiranje događaja
    //         $dogadjaj = Dogadjaj::create($validatedData);

    //         // Povratni JSON odgovor
    //         return response()->json([
    //             'message' => 'Događaj je uspešno kreiran',
    //             'dogadjaj' => $dogadjaj
    //         ], 201);
    //     } catch (\Exception $e) {
    //         // Logovanje greške
    //         Log::error('Greška pri kreiranju događaja: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

    //         // Povratni JSON odgovor u slučaju greške
    //         return response()->json(['error' => 'Došlo je do greške pri kreiranju događaja'], 500);
    //     }
    // }


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
        try {
            // Validacija podataka
            $validatedData = $request->validate([
                'ime_dogadjaja' => 'required|string|max:255',
                'lokacija' => 'required|string|max:255',
                'opis' => 'nullable|string',
                'status' => 'required|string|in:zakazan,odrzan,otkazan',
                'datum_registracije' => 'required|date_format:Y-m-d'
            ]);

            // Pronalazak događaja
            $dogadjaj = Dogadjaj::find($id);

            if (!$dogadjaj) {
                return response()->json(['error' => 'Događaj nije pronađen'], 404);
            }

            // Ažuriranje događaja
            $dogadjaj->update($validatedData);

            return response()->json([
                'message' => 'Događaj je uspešno ažuriran',
                'dogadjaj' => $dogadjaj
            ], 200);
        } catch (\Exception $e) {
            // Logovanje greške
            Log::error('Greška pri ažuriranju događaja: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return response()->json(['error' => 'Došlo je do greške pri ažuriranju događaja'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $dogadjaj = Dogadjaj::find($id);

            if (!$dogadjaj) {
                return response()->json(['error' => 'Događaj nije pronađen'], 404);
            }

            $dogadjaj->delete();

            return response()->json(['message' => 'Događaj je uspešno obrisan'], 200);
        } catch (\Exception $e) {
            // Logovanje greške
            Log::error('Greška pri brisanju događaja: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            return response()->json(['error' => 'Došlo je do greške pri brisanju događaja'], 500);
        }
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


    // FILTER CAJ
    public function pretraga(Request $request)
{
    $naziv = $request->input('naziv');
    $lokacija = $request->input('lokacija');
    $status = $request->input('status');

    // Koristi query za pretragu sa opcionalnim filterima
    $query = Dogadjaj::query();

    if ($naziv) {
        $query->where('ime_dogadjaja', 'LIKE', "%$naziv%");
    }

    if ($lokacija) {
        $query->where('lokacija', 'LIKE', "%$lokacija%");
    }

    if ($status) {
        $query->where('status', $status);
    }

    // Dodaj paginaciju (10 po stranici)
    $dogadjaji = $query->paginate(10);

    return response()->json($dogadjaji);
}


    // public function pretraga(Request $request)
    // {
    //     $naziv = $request->input('naziv');
    //     $lokacija = $request->input('lokacija');
    //     $status = $request->input('status');

    //     // Koristi query scopes za pretragu i paginaciju
    //     $dogadjaji = Dogadjaj::query()
    //         ->naziv($naziv)
    //         ->lokacija($lokacija)
    //         ->status($status)
    //         ->paginate(10); // Dodaj paginaciju

    //     return response()->json($dogadjaji);
    // }

    // public function pretraga(Request $request)
    // {
    //     $naziv = $request->input('naziv');
    //     $lokacija = $request->input('lokacija');
    //     $status = $request->input('status');

    //     // Koristi query scopes za pretragu
    //     $dogadjaji = Dogadjaj::query()
    //         ->naziv($naziv)
    //         ->lokacija($lokacija)
    //         ->status($status)
    //         ->get();

    //     return view('dogadjaji.pretraga', compact('dogadjaji', 'naziv', 'lokacija', 'status'));
    // }
}