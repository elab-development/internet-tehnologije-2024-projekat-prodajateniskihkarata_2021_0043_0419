<?php

namespace App\Http\Controllers;

use App\Models\Korisnik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'ime_prezime' => 'required|string',
            'email' => 'required|string|email|unique:korisnik',
            'lozinka' => 'required|string|min:6|confirmed',
        ]);

        $user = new Korisnik([
            'ime_prezime' => $request->ime_prezime,
            'email' => $request->email,
            'lozinka' => Hash::make($request->lozinka),
            'uloga' => 'kupac',
        ]);

        $user->save();

        return response()->json([
            'message' => 'Uspešno ste se registrovali!'
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'lozinka' => 'required|string',
        ]);

        $credentials = $request->only('email', 'lozinka');

        if (Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Uspešno ste se ulogovali!',
                'user' => Auth::user(),
            ], 200);
        } else {
            return response()->json([
                'message' => 'Neispravni podaci za prijavu.'
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json([
            'message' => 'Uspešno ste se odjavili!'
        ], 200);
    }

    public function resetPassword(Request $request)
{
    $request->validate([
        'email' => 'required|string|email',
        'new_password' => 'required|string|min:6|confirmed',
    ]);

    $user = Korisnik::where('email', $request->email)->first();

    if (!$user) {
        return response()->json(['message' => 'Korisnik nije pronađen'], 404);
    }

    $user->lozinka = Hash::make($request->new_password);
    $user->save();

    return response()->json(['message' => 'Lozinka je uspešno izmenjena'], 200);
}

}

