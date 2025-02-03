<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Korisnik;
use Illuminate\Support\Facades\Hash;
use Illuminate\Container\Attributes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;


class KorisnikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //return response()->json(Korisnik::all(), 200);



        // Osigurajte da se keš briše nakon kreiranja ili brisanja korisnika
        Cache::forget('korisnici');

        // Keširanje liste korisnika na 60 minuta
        $korisnici = Cache::remember('korisnici', 60 * 60, function () {
            return Korisnik::all();
        });

        return response()->json($korisnici, 200);





        // try {
        //     $korisnici = Korisnik::all();
        //     return response()->json($korisnici, 200);
        // } catch (\Exception $e) {
        //     Log::error('Greška u metodi index: ' . $e->getMessage());
        //     return response()->json(['error' => 'Internal Server Error'], 500);
        // }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        try {
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

            // Uklanjanje keša za listu korisnika
            Cache::forget('korisnici');

            // Vraćanje novokreiranog korisnika sa status kodom 201
            return response()->json([
                'message' => 'Korisnik je uspešno kreiran',
                'korisnik' => $korisnik,
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Obrada validacionih grešaka
            return response()->json([
                'message' => 'Validacija nije prošla',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Exception $e) {
            // Obrada neočekivanih grešaka
            Log::error('Greška pri kreiranju korisnika: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'message' => 'Došlo je do neočekivane greške',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    /**
     * Store a newly created resource in storage.
     */


    //sr
    // public function store(Request $request)
    // {
    //     try {
    //         // Validacija podataka iz zahteva
    //         $validatedData = $request->validate([
    //             'ime' => 'required|string|max:255',
    //             'email' => 'required|string|email|max:255|unique:korisniks',
    //             'lozinka' => 'required|string|min:8',
    //             'uloga' => 'required|string|in:admin,auth_user,guest',
    //             'datum_registracije' => 'required|date_format:Y-m-d H:i:s'
    //         ]);

    //         // Kreiranje novog korisnika
    //         $korisnik = Korisnik::create($validatedData);

    //         // Uklanjanje keša za listu korisnika
    //         Cache::forget('korisnici');

    //         // Vraćanje novokreiranog korisnika sa status kodom 201
    //         return response()->json($korisnik, 201);
    //     } catch (\Exception $e) {
    //         Log::error('Greška prilikom kreiranja korisnika: ' . $e->getMessage());
    //         return response()->json(['error' => 'Greška prilikom kreiranja korisnika.'], 500);
    //     }
    // }

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

    // STARA FUNKCIJA RADI UGLAVNOM
    // public function update(Request $request, $id)
    // {
    //     // Validacija podataka iz zahteva
    //     $validatedData = $request->validate([
    //         'ime' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:korisniks,email,' . $id,
    //         'lozinka' => 'sometimes|string|min:8',
    //         'uloga' => 'required|string|in:admin,auth_user,guest',
    //         'datum_registracije' => 'required|date_format:Y-m-d H:i:s'
    //     ]);

    //     // Pronalazak korisnika po ID-ju
    //     $korisnik = Korisnik::find($id);

    //     if (!$korisnik) {
    //         return response()->json(['error' => 'Korisnik nije pronađen'], 404);
    //     }

    //     // Ažuriranje lozinke ako je postavljena
    //     if (isset($validatedData['lozinka'])) {
    //         $validatedData['lozinka'] = Hash::make($validatedData['lozinka']);
    //     } else {
    //         unset($validatedData['lozinka']);
    //     }

    //     // Ažuriranje korisnika
    //     $korisnik->update($validatedData);
    //     return response()->json($korisnik, 200);
    // }

// NOVA F-JA RADI ZA SAJT
    public function update(Request $request, $id)
    {
        $user = Korisnik::findOrFail($id);

        // Validacija unosa
        $validated = $request->validate([
            'ime' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'uloga' => 'required|in:guest,auth_user,admin',
            'lozinka' => 'nullable|string|min:8',
        ]);

        // Ažuriramo korisnika, ali ne menjamo datum registracije
        $user->ime = $validated['ime'];
        $user->email = $validated['email'];
        $user->uloga = $validated['uloga'];

        if ($request->has('lozinka') && !empty($request->lozinka)) {
            $user->password = bcrypt($validated['lozinka']);
        }

        $user->save();

        return response()->json($user);
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

        // Brišemo keš nakon brisanja korisnika
        Cache::forget('korisnici');

        return response()->json(null, 204);


        // $korisnik = Korisnik::find($id);

        // if (!$korisnik) {
        //     return response()->json(['error' => 'Korisnik nije pronađen'], 404);
        // }

        // $korisnik->delete();
        // return response()->json(null, 204);
    }

    // public function promeniLozinku(Request $request, Korisnik $korisnik)
    // {
    //     try {
    //         Log::info('Započeo proces promene lozinke.');

    //         $request->validate([
    //             'stara_lozinka' => 'required',
    //             'nova_lozinka' => 'required|min:8',
    //         ]);

    //         Log::info('Validacija prodata.');

    //         // Provera stara lozinka
    //         if (!Hash::check($request->stara_lozinka, $korisnik->lozinka)) {
    //             Log::error('Stara lozinka nije ispravna.');
    //             return response()->json(['error' => 'Stara lozinka nije ispravna.'], 400);
    //         }

    //         // Promena lozinke
    //         $korisnik->lozinka = Hash::make($request->nova_lozinka);
    //         $korisnik->save();

    //         Log::info('Lozinka uspešno promenjena.');

    //         return response()->json(['message' => 'Lozinka je uspešno promenjena.'], 200);
    //     } catch (\Exception $e) {
    //         Log::error('Greška prilikom promene lozinke: ' . $e->getMessage());
    //         return response()->json(['error' => 'Došlo je do greške prilikom promene lozinke.'], 500);
    //     }
    // }


    //OVO RADI

    //     public function promeniLozinku(Request $request, $id)
// {
//     try {
//         Log::info('Započeo proces promene lozinke.');

    //         $request->validate([
//             'stara_lozinka' => 'required',
//             'nova_lozinka' => 'required|min:8|confirmed',
//         ]);

    //         $korisnik = Korisnik::find($id);

    //         if (!$korisnik) {
//             Log::error('Korisnik nije pronađen.');
//             return response()->json(['error' => 'Korisnik nije pronađen'], 404);
//         }

    //         // Provera stara lozinka
//         if (!Hash::check($request->stara_lozinka, $korisnik->lozinka)) {
//             Log::error('Stara lozinka nije ispravna.');
//             return response()->json(['error' => 'Stara lozinka nije ispravna.'], 400);
//         }

    //         // Promena lozinke
//         $korisnik->lozinka = Hash::make($request->nova_lozinka);
//         $korisnik->save();

    //         Log::info('Lozinka uspešno promenjena.');

    //         return response()->json(['message' => 'Lozinka je uspešno promenjena.'], 200);
//     } catch (\Exception $e) {
//         Log::error('Greška prilikom promene lozinke: ' . $e->getMessage());
//         return response()->json(['error' => 'Došlo je do greške prilikom promene lozinke.'], 500);
//     }
// }



    public function promeniLozinku(Request $request, $id)
    {
        try {
            Log::info('Započeo proces promene lozinke za korisnika ID: ' . $id);

            $request->validate([
                'stara_lozinka' => 'required',
                'nova_lozinka' => 'required|min:8|confirmed',
            ]);

            $korisnik = Korisnik::find($id);

            if (!$korisnik) {
                Log::error('Korisnik nije pronađen.');
                return response()->json(['error' => 'Korisnik nije pronađen'], 404);
            }

            // Provera stara lozinka
            if (!Hash::check($request->stara_lozinka, $korisnik->lozinka)) {
                Log::error('Stara lozinka nije ispravna.');
                return response()->json(['error' => 'Stara lozinka nije ispravna.'], 400);
            }

            // Promena lozinke
            $korisnik->lozinka = $request->nova_lozinka;
            $korisnik->save();

            Log::info('Lozinka uspešno promenjena za korisnika ID: ' . $id);

            return response()->json(['message' => 'Lozinka je uspešno promenjena.'], 200);
        } catch (\Exception $e) {
            Log::error('Greška prilikom promene lozinke: ' . $e->getMessage());
            return response()->json(['error' => 'Došlo je do greške prilikom promene lozinke.'], 500);
        }
    }


    // public function promeniLozinku(Request $request, $id)
// {
//     try {
//         Log::info('Započeo proces promene lozinke za korisnika ID: ' . $id);

    //         $request->validate([
//             'stara_lozinka' => 'required',
//             'nova_lozinka' => 'required|min:8|confirmed',
//         ]);

    //         $korisnik = Korisnik::find($id);

    //         if (!$korisnik) {
//             Log::error('Korisnik nije pronađen.');
//             return response()->json(['error' => 'Korisnik nije pronađen'], 404);
//         }

    //         // Provera stara lozinka
//         if (!Hash::check($request->stara_lozinka, $korisnik->lozinka)) {
//             Log::error('Stara lozinka nije ispravna.');
//             return response()->json(['error' => 'Stara lozinka nije ispravna.'], 400);
//         }

    //         // Promena lozinke
//         $korisnik->lozinka = Hash::make($request->nova_lozinka);
//         $korisnik->save();

    //         Log::info('Lozinka uspešno promenjena za korisnika ID: ' . $id);

    //         return response()->json(['message' => 'Lozinka je uspešno promenjena.'], 200);
//     } catch (\Exception $e) {
//         Log::error('Greška prilikom promene lozinke: ' . $e->getMessage());
//         return response()->json(['error' => 'Došlo je do greške prilikom promene lozinke.'], 500);
//     }
// }

    public function getUser(Request $request)
    {
        $korisnik = $request->user();

        if (!$korisnik) {
            return response()->json(['error' => 'Korisnik nije prijavljen'], 401);
        }

        return response()->json([
            'id' => $korisnik->id,
            'email' => $korisnik->email,
            'ime' => $korisnik->ime,
            'uloga' => $korisnik->uloga,
            'datum_registracije' => $korisnik->datum_registracije,
        ], 200);
    }

}