<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use App\Models\Korisnik;

class AuthController extends Controller
{
    // public function register(Request $request)
    // {
    //     try {
    //         // Validacija podataka iz zahteva
    //         $validatedData = $request->validate([
    //             'ime' => 'required|string|max:255',
    //             'email' => 'required|string|email|max:255|unique:korisniks',
    //             'lozinka' => 'required|string|min:8|confirmed',
    //             'uloga' => 'required|string|in:admin,auth_user,guest',
    //             'datum_registracije' => 'required|date_format:Y-m-d H:i:s'
    //         ]);

    //         // Kreiranje novog korisnika
    //         $korisnik = Korisnik::create($validatedData);

    //         // Generisanje tokena
    //         $token = $korisnik->createToken('auth_token')->plainTextToken;

    //         // Vraćanje odgovora sa tokenom
    //         return response()->json(['access_token' => $token, 'token_type' => 'Bearer'], 201);
    //     } catch (\Exception $e) {
    //         // Logovanje greške
    //         Log::error('Error during registration: ' . $e->getMessage());
    //         return response()->json(['error' => 'Internal Server Error'], 500);
    //     }
    // }

    // public function register(Request $request)
    // {
    //     try {
    //         // Validacija podataka iz zahteva
    //         $validatedData = $request->validate([
    //             'ime' => 'required|string|max:255',
    //             'email' => 'required|string|email|max:255|unique:korisniks,email',
    //             'lozinka' => 'required|string|min:8|confirmed',
    //             'uloga' => 'required|string|in:admin,auth_user,guest',
    //             'datum_registracije' => 'required|date_format:Y-m-d H:i:s'
    //         ]);

    //         // Kreiranje novog korisnika
    //         $korisnik = Korisnik::create([
    //             'ime' => $validatedData['ime'],
    //             'email' => $validatedData['email'],
    //             'lozinka' => Hash::make($validatedData['lozinka']),
    //             'uloga' => $validatedData['uloga'],
    //             'datum_registracije' => $validatedData['datum_registracije']
    //         ]);

    //         // Generisanje tokena
    //         $token = $korisnik->createToken('auth_token')->plainTextToken;

    //         // Vraćanje odgovora sa tokenom
    //         return response()->json(['access_token' => $token, 'token_type' => 'Bearer'], 201);
    //     } catch (\Exception $e) {
    //         // Logovanje greške
    //         Log::error('Error during registration: ' . $e->getMessage());
    //         return response()->json(['error' => 'Internal Server Error'], 500);
    //     }
    // }

    public function register(Request $request)
    {
        try {
            // Validacija podataka
            $validatedData = $request->validate([
                'ime' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:korisniks,email',
                'lozinka' => 'required|string|min:8|confirmed',
                'uloga' => 'required|string|in:admin,auth_user,guest',
                'datum_registracije' => 'required|date_format:Y-m-d H:i:s',
            ]);

            // Kreiranje korisnika
            $korisnik = Korisnik::create($validatedData);

            // Generisanje tokena
            $token = $korisnik->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'email' => $korisnik->email,
                    'ime' => $korisnik->ime,
                    'uloga' => $korisnik->uloga,
                    'datum_registracije' => $korisnik->datum_registracije,
                ],
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Rukovanje validacionim greškama
            return response()->json([
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            // Logovanje svih ostalih grešaka
            Log::error('Error during registration: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function login(Request $request)
    {
        try {
            // Validacija podataka
            $request->validate([
                'email' => 'required|string|email',
                'lozinka' => 'required|string',
            ]);

            // Logovanje podataka za proveru
            Log::info('Attempting login with email: ' . $request->email);

            // Dohvatanje korisnika
            $korisnik = Korisnik::where('email', $request->email)->first();

            if (!$korisnik) {
                Log::warning('No user found with email: ' . $request->email);
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // Provera lozinke
            if (!Hash::check($request->lozinka, $korisnik->lozinka)) {
                Log::warning('Incorrect password for email: ' . $request->email);
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

            // Generisanje tokena
            $token = $korisnik->createToken('auth_token')->plainTextToken;

            if (!$token) {
                Log::error('Failed to generate token for user: ' . $korisnik->email);
                return response()->json(['error' => 'Token generation failed'], 500);
            }

            // Vraćanje odgovora sa tokenom i korisničkim podacima
            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'email' => $korisnik->email,
                    'ime' => $korisnik->ime,
                    'uloga' => $korisnik->uloga,
                    'datum_registracije' => $korisnik->datum_registracije,
                ],
            ], 200);

        } catch (\Exception $e) {
            // Logovanje greške
            Log::error('Error during login: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            // Briše sve tokene korisnika
            $request->user()->tokens()->delete();

            return response()->json([
                'message' => 'Successfully logged out'
            ], 200);
        } catch (\Exception $e) {
            // Logovanje greške
            Log::error('Error during logout: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }


    // public function login(Request $request)
    // {
    //     // Validacija podataka iz zahteva
    //     $credentials = $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);

    //     // Pokušaj autentifikacije korisnika
    //     if (!Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
    //         return response()->json(['message' => 'Unauthorized'], 401);
    //     }

    //     // Dohvatanje autentifikovanog korisnika
    //     $korisnik = Auth::korisnik();

    //     // Generisanje tokena
    //     $token = $korisnik->createToken('auth_token')->plainTextToken;

    //     // Vraćanje odgovora sa tokenom i korisničkim podacima
    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'Bearer',
    //         'role' => $korisnik->uloga,
    //     ], 200);
    // }




    // public function register(Request $request)
    // {
    //     try {
    //         // Validacija podataka iz zahteva
    //         $validatedData = $request->validate([
    //             'ime' => 'required|string|max:255',
    //             'email' => 'required|string|email|max:255|unique:korisniks',
    //             'lozinka' => 'required|string|min:8|confirmed',
    //             'uloga' => 'required|string|in:admin,auth_user,guest',
    //             'datum_registracije' => 'required|date_format:Y-m-d H:i:s'
    //         ]);

    //         // Kreiranje novog korisnika
    //         $korisnik = Korisnik::create([
    //             'ime' => $validatedData['ime'],
    //             'email' => $validatedData['email'],
    //             'lozinka' => Hash::make($validatedData['lozinka']),
    //             'uloga' => $validatedData['uloga'],
    //             'datum_registracije' => $validatedData['datum_registracije']
    //         ]);

    //         // Generisanje tokena
    //         $token = $korisnik->createToken('auth_token')->plainTextToken;

    //         // Vraćanje odgovora sa tokenom
    //         return response()->json(['access_token' => $token, 'token_type' => 'Bearer'], 201);
    //     } catch (\Exception $e) {
    //         // Logovanje greške
    //         Log::error('Error during registration: ' . $e->getMessage());
    //         return response()->json(['error' => 'Internal Server Error'], 500);
    //     }
    // }

    // public function login(){

    //     validator(request()->all(), [
    //         'email'=> ['required', 'email'],
    //         'password'=> ['required']
    //     ])->validate();

    //     $korisnik = Korisnik::where('email', request('email'))->first();

    //     if(Hash::check(request('password'), $korisnik->getAuthPassword())) {
    //         return[
    //             'token'=>$korisnik->createToken(time())->plainTextToken
    //         ];
    //     }

    // }

    // public function login(Request $request)
    // {
    //     $credentials = $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);

    //     if (!Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
    //         return response()->json(['message' => 'Unauthorized'], 401);
    //     }

    //     $user = Auth::user();
    //     $korisnik = Korisnik::where('email', $credentials['email'])->first();

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return response()->json([
    //         'access_token' => $token,
    //         'token_type' => 'Bearer',
    //         'role' => $korisnik->uloga->naziv,
    //     ], 200);
    // }

    // public function login(Request $request)
    // {
    //     try {
    //         // Validacija podataka iz zahteva
    //         $request->validate([
    //             'email' => 'required|string|email',
    //             'lozinka' => 'required|string',
    //         ]);

    //         // Logovanje podataka za proveru
    //         Log::info('Attempting login with email: ' . $request->email);

    //         // Dohvatanje korisnika
    //         $korisnik = Korisnik::where('email', $request->email)->first();

    //         if (!$korisnik || !Hash::check($request->lozinka, $korisnik->lozinka)) {
    //             Log::error('Provided credentials are incorrect for email: ' . $request->email);
    //             throw ValidationException::withMessages([
    //                 'email' => ['The provided credentials are incorrect.'],
    //             ]);
    //         }

    //         // Generisanje tokena
    //         $token = $korisnik->createToken('auth_token')->plainTextToken;

    //         // Vraćanje odgovora sa tokenom i korisničkim podacima bez lozinke
    //         return response()->json([
    //             'access_token' => $token,
    //             'token_type' => 'Bearer',
    //             'user' => [
    //                 'email' => $korisnik->email,
    //                 'ime' => $korisnik->ime,
    //                 'uloga' => $korisnik->uloga,
    //                 'datum_registracije' => $korisnik->datum_registracije,
    //             ]
    //         ], 200);
    //     } catch (\Exception $e) {
    //         // Logovanje greške
    //         Log::error('Error during login: ' . $e->getMessage());
    //         return response()->json(['error' => 'Internal Server Error'], 500);
    //     }
    // }

    //     public function login(Request $request)
// {
//     try {
//         // Validacija podataka iz zahteva
//         $request->validate([
//             'email' => 'required|string|email',
//             'lozinka' => 'required|string',
//         ]);

    //         // Logovanje podataka za proveru
//         Log::info('Attempting login with email: ' . $request->email);

    //         // Dohvatanje korisnika
//         $korisnik = Korisnik::where('email', $request->email)->first();

    //         if (!$korisnik || !Hash::check($request->lozinka, $korisnik->lozinka)) {
//             Log::error('Provided credentials are incorrect for email: ' . $request->email);
//             throw ValidationException::withMessages([
//                 'email' => ['The provided credentials are incorrect.'],
//             ]);
//         }

    //         // Generisanje tokena
//         $token = $korisnik->createToken('auth_token')->plainTextToken;

    //         // Vraćanje odgovora sa tokenom i korisničkim podacima bez lozinke
//         return response()->json([
//             'access_token' => $token,
//             'token_type' => 'Bearer',
//             'user' => [
//                 'email' => $korisnik->email,
//                 'ime' => $korisnik->ime,
//                 'uloga' => $korisnik->uloga,
//                 'datum_registracije' => $korisnik->datum_registracije,
//             ]
//         ], 200);
//     } catch (\Exception $e) {
//         // Logovanje greške
//         Log::error('Error during login: ' . $e->getMessage());
//         return response()->json(['error' => 'Internal Server Error'], 500);
//     }
// }
    // public function logout(Request $request)
    // {
    //     try {
    //         // Brisanje trenutnog tokena
    //         $request->user()->currentAccessToken()->delete();

    //         // Vraćanje odgovora
    //         return response()->json(['message' => 'Successfully logged out'], 200);
    //     } catch (\Exception $e) {
    //         // Logovanje greške
    //         Log::error('Error during logout: ' . $e->getMessage());
    //         return response()->json(['error' => 'Internal Server Error'], 500);
    //     }
    // }
}
