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
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;



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
            ]);

            // Postavljanje default vrednosti za ulogu i datum registracije
            $validatedData['uloga'] = 'auth_user';
            $validatedData['datum_registracije'] = now();

            // // Kreiranje korisnika
            // $korisnik = Korisnik::create([
            //     'ime' => $validatedData['ime'],
            //     'email' => $validatedData['email'],
            //     'lozinka' => Hash::make($validatedData['lozinka']),
            //     'uloga' => $validatedData['uloga'],
            //     'datum_registracije' => $validatedData['datum_registracije'],
            // ]);

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
    // GPT
    public function forgotPassword(Request $request)
    {
        try {
            // Validacija emaila
            $request->validate(['email' => 'required|email']);

            // Provera da li korisnik postoji
            $korisnik = Korisnik::where('email', $request->email)->first();

            if (!$korisnik) {
                Log::warning('Password reset requested for non-existent email: ' . $request->email);
                return response()->json(['error' => 'User not found'], 404);
            }

            // Generisanje privremenog tokena za reset lozinke
            $token = Str::random(60);

            // Smeštanje tokena u bazu ili korišćenje tabele `password_resets`
            DB::table('password_resets')->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => Hash::make($token),
                    'created_at' => now(),
                ]
            );

            // Slanje email-a korisniku (možeš koristiti queue za asinkrono slanje)
            Mail::to($korisnik->email)->send(new ResetPasswordMail($token));

            return response()->json(['message' => 'Reset password email sent'], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error during password reset: ' . json_encode($e->errors()));
            return response()->json(['error' => 'Validation failed', 'details' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error during password reset: ' . $e->getMessage());
            return response()->json(['error' => 'Internal Server Error'], 500);
        }
    }



    // Metoda za resetovanje lozinke
    public function resetPassword(Request $request)
    {
        // Validacija podataka iz zahteva
        $request->validate([
            'email' => 'required|string|email',
        ]);

        // Dohvatanje korisnika
        $korisnik = Korisnik::where('email', $request->input('email'))->first();

        if (!$korisnik) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Generisanje nove lozinke
        $newPassword = Str::random(8);

        // Postavljanje nove lozinke
        $korisnik->lozinka = Hash::make($newPassword);
        $korisnik->save();

        // Slanje emaila sa novom lozinkom (ovo je samo primer, u stvarnom svetu koristili bismo servis za slanje emailova)
        Mail::raw('Your new password is: ' . $newPassword, function ($message) use ($korisnik) {
            $message->to($korisnik->email)
                ->subject('Password Reset');
        });

        // Vraćanje odgovora sa porukom o uspešnom resetovanju lozinke
        return response()->json(['message' => 'Password reset successfully. Please check your email for the new password.'], 200);
    }


    public function showResetForm($token)
    {
        // Provera da li je token validan
        $resetRequest = DB::table('password_resets')->where('token', $token)->first();

        if (!$resetRequest) {
            return redirect()->route('password.request')->withErrors(['token' => 'This password reset token is invalid.']);
        }

        return view('auth.reset-password', ['token' => $token]);
    }




    // GPT METODA ZA RESET, MOZDA JE BOLJA ALTERNATIVA (ALI NE RADI U POSTMANU)
    // public function resetPassword(Request $request)
    // {
    //     $request->validate([
    //         'token' => 'required',
    //         'email' => 'required|email',
    //         'password' => 'required|confirmed|min:8',
    //     ]);

    //     $resetRequest = DB::table('password_resets')
    //         ->where('token', $request->token)
    //         ->where('email', $request->email)
    //         ->first();

    //     if (!$resetRequest) {
    //         return redirect()->back()->withErrors(['email' => 'Invalid token or email.']);
    //     }

    //     $korisnik = Korisnik::where('email', $request->email)->first();
    //     if (!$korisnik) {
    //         return redirect()->back()->withErrors(['email' => 'User not found.']);
    //     }

    //     $korisnik->password = Hash::make($request->password);
    //     $korisnik->save();

    //     DB::table('password_resets')->where('email', $request->email)->delete();

    //     return redirect()->route('login')->with('status', 'Password reset successfully.');
    // }



    // public function forgotPassword(Request $request)
    // {
    //     // Validacija email-a
    //     $request->validate(['email' => 'required|email']);

    //     // Provera da li korisnik postoji
    //     $korisnik = Korisnik::where('email', $request->email)->first();

    //     if (!$korisnik) {
    //         return response()->json(['error' => 'Korisnik nije pronađen'], 404);
    //     }

    //     // Generisanje privremenog tokena
    //     $token = Str::random(60);

    //     // Alternativno: generisanje tokena sa vremenskim ograničenjem
    //     // Koristite JWT biblioteku za generisanje tokena
    //     $expiresAt = now()->addMinutes(30);
    //     $tokenData = [
    //         'email' => $korisnik->email,
    //         'expires_at' => $expiresAt
    //     ];

    //     // Token sa vremenskim ograničenjem (ako koristite JWT)
    //     // $token = JWT::encode($tokenData, config('app.key'));

    //     // Slanje email-a korisniku
    //     Mail::to($korisnik->email)->send(new ResetPasswordMail($token));

    //     return response()->json(['message' => 'Reset password email sent'], 200);
    // }





    //NEKI DRUGI NACIN
    // public function resetPassword(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'token' => 'required|string',
    //         'new_password' => 'required|string|min:8',
    //     ]);

    //     // Provera da li korisnik postoji
    //     $korisnik = Korisnik::where('email', $request->email)->first();

    //     if (!$korisnik) {
    //         return response()->json(['error' => 'Korisnik nije pronađen'], 404);
    //     }

    //     // Validacija tokena (ako ne koristite JWT, validirajte prema vašoj logici)
    //     // Ako ste koristili JWT:
    //     // $tokenData = JWT::decode($request->token, config('app.key'), ['HS256']);
    //     // if ($tokenData->email !== $request->email || now() > $tokenData->expires_at) {
    //     //     return response()->json(['error' => 'Nevažeći ili istekli token'], 400);
    //     // }

    //     // Resetovanje lozinke
    //     $korisnik->lozinka = bcrypt($request->new_password);
    //     $korisnik->save();

    //     return response()->json(['message' => 'Lozinka je uspešno promenjena'], 200);
    // }







    // Metoda za resetovanje lozinke
    // public function resetPassword(Request $request)
    // {
    //     // Validacija podataka iz zahteva
    //     $request->validate([
    //         'email' => 'required|string|email',
    //     ]);

    //     // Dohvatanje korisnika
    //     $korisnik = Korisnik::where('email', $request->input('email'))->first();

    //     if (!$korisnik) {
    //         return response()->json(['message' => 'User not found'], 404);
    //     }

    //     // Generisanje nove lozinke
    //     $newPassword = Str::random(8);

    //     // Postavljanje nove lozinke
    //     $korisnik->lozinka = Hash::make($newPassword);
    //     $korisnik->save();

    //     // Vraćanje odgovora sa novom lozinkom (u stvarnom svetu, poslali bismo email)
    //     return response()->json(['message' => 'Password reset successfully', 'new_password' => $newPassword], 200);
    // }


    // GPT
    // public function resetPassword(Request $request)
    // {
    //     // Validacija podataka
    //     $request->validate([
    //         'email' => 'required|email',
    //         'token' => 'required|string',
    //         'new_password' => 'required|string|min:8|confirmed',
    //     ]);

    //     // Provera da li token postoji
    //     $resetRequest = DB::table('password_resets')->where('email', $request->email)->first();

    //     if (!$resetRequest || !Hash::check($request->token, $resetRequest->token)) {
    //         return response()->json(['error' => 'Invalid token'], 400);
    //     }

    //     // Provera korisnika
    //     $korisnik = Korisnik::where('email', $request->email)->first();

    //     if (!$korisnik) {
    //         return response()->json(['error' => 'User not found'], 404);
    //     }

    //     // Promena lozinke
    //     $korisnik->update(['lozinka' => Hash::make($request->new_password)]);

    //     // Brisanje tokena iz baze
    //     DB::table('password_resets')->where('email', $request->email)->delete();

    //     return response()->json(['message' => 'Password successfully updated'], 200);
    // }


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
