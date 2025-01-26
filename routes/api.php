<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;


use App\Http\Controllers\KorisnikController;
use App\Http\Controllers\DogadjajController;
use App\Http\Controllers\KartaController;
use App\Http\Controllers\TipKarteController;
use App\Http\Controllers\PlacanjeController;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Cache;


Route::get('/dogadjaji/pretraga', [DogadjajController::class, 'pretraga']);


// Rute dostupne svima (bez autentifikacije)
Route::get('/dogadjaji', [DogadjajController::class, 'index']);
Route::get('/dogadjaji/{id}', [DogadjajController::class, 'show']);
Route::get('/dogadjaji/pretraga', [DogadjajController::class, 'pretraga'])->name('api.dogadjaji.pretraga');
Route::get('/dogadjaji/filter', [DogadjajController::class, 'filter']);

// Rute zaštićene autentifikacijom
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/dogadjaji', [DogadjajController::class, 'store']);
    Route::put('/dogadjaji/{id}', [DogadjajController::class, 'update']);
    Route::delete('/dogadjaji/{id}', [DogadjajController::class, 'destroy']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('korisnici/{korisnik}/promena-lozinke', [KorisnikController::class, 'promeniLozinku']);
    Route::post('upload-fajlova', [FileController::class, 'store'])->name('upload.store');
    Route::get('dogadjaji/external-data', [DogadjajController::class, 'fetchExternalData']);
    Route::get('export-dogadjaji', [DogadjajController::class, 'export']);

    // Resource rute
    Route::apiResource('korisnici', KorisnikController::class);
    Route::apiResource('dogadjaji', DogadjajController::class)->except(['index', 'show']);
    Route::apiResource('karte', KartaController::class)->except(['index', 'show']);
    Route::apiResource('tipovi-karata', TipKarteController::class);
    Route::apiResource('placanja', PlacanjeController::class);

    // Admin rute
    Route::middleware(['role:admin'])->group(function () {
        Route::post('/admin-create', [ApiController::class, 'create'])->name('api.admin.create');
        Route::put('/admin-update', [ApiController::class, 'update'])->name('api.admin.update');
        Route::delete('/admin-delete', [ApiController::class, 'delete'])->name('api.admin.delete');
    });

    // Autentifikovani korisnici
    Route::middleware(['role:auth_user'])->group(function () {
        Route::post('/purchase-tickets', [ApiController::class, 'purchaseTickets'])->name('api.purchase.tickets');
        Route::post('/reserve-tickets', [ApiController::class, 'reserveTickets'])->name('api.reserve.tickets');
    });
});

// Rute za autentifikaciju
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'resetPassword']);

// Rute za neulogovane korisnike (gost)
Route::get('/guest-view-dogadjaj/{id}', [ApiController::class, 'showDogadjaj'])->name('api.guest.viewDogadjaj');
Route::get('/guest-view-dogadjaji', [ApiController::class, 'indexDogadjaji'])->name('api.guest.indexDogadjaji');
Route::get('/guest-view', [ApiController::class, 'guestView'])->name('api.guest.view');

// Rute za paginaciju i filtriranje događaja (dostupne svima)
Route::get('dogadjaji', [DogadjajController::class, 'index']);
Route::get('dogadjaji/filter', [DogadjajController::class, 'filter']);

// Ruta za prikaz forme za upload fajlova (ako je potrebno)
Route::get('upload-fajlova', [FileController::class, 'create'])->name('upload.create');

// Ruta za čuvanje uploadovanih fajlova
Route::post('upload-fajlova', [FileController::class, 'store'])->name('upload.store');

Route::delete('clear-cache', function () {
    Cache::forget('korisnici');
    return response()->json(['message' => 'Cache cleared'], 200);
});







// POTPUNO ISPRAVNE RUTE, OVE IZNAD PRERADJENE

// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('/dogadjaji', [DogadjajController::class, 'store']);
//     Route::put('/dogadjaji/{id}', [DogadjajController::class, 'update']);
//     Route::delete('/dogadjaji/{id}', [DogadjajController::class, 'destroy']);
//     Route::get('/dogadjaji/{id}', [DogadjajController::class, 'show']);
//     Route::get('/dogadjaji', [DogadjajController::class, 'index']);
// });
// Route::get('/login', function () {
//     return response()->json(['error' => 'Morate biti prijavljeni za pristup.'], 401);
// })->name('login');


// Route::middleware('auth:sanctum')->group(function () {
//     Route::resource('karte', KartaController::class)->except(['index', 'show']);
// });

// // Otvorene rute
// Route::get('karte', [KartaController::class, 'index']);
// Route::get('karte/{id}', [KartaController::class, 'show']);


// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('korisnici/{korisnik}/promena-lozinke', [KorisnikController::class, 'promeniLozinku']);
// });

// //
// Route::get('/dogadjaji/pretraga', [DogadjajController::class, 'pretraga'])->name('api.dogadjaji.pretraga');
// Route::get('/dogadjaji/pretraga', [DogadjajController::class, 'filter']);







// // Rute za autentifikaciju
// Route::post('register', [AuthController::class, 'register']);
// Route::post('login', [AuthController::class, 'login']);
// Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
// Route::post('reset-password', [AuthController::class, 'resetPassword']);
// Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
// Route::post('password/reset', [AuthController::class, 'resetPassword']);

// // Rute za neulogovane korisnike (gost)
// Route::get('/guest-view-dogadjaj/{id}', [ApiController::class, 'showDogadjaj'])->name('api.guest.viewDogadjaj');
// Route::get('/guest-view-dogadjaji', [ApiController::class, 'indexDogadjaji'])->name('api.guest.indexDogadjaji');
// Route::get('/guest-view', [ApiController::class, 'guestView'])->name('api.guest.view');

// // Rute za paginaciju i filtriranje događaja (dostupne svima)
// // Route::get('dogadjaji', [DogadjajController::class, 'index']);
// // Route::get('dogadjaji/filter', [DogadjajController::class, 'filter']);

// // Rute za paginaciju i filtriranje događaja (koje zahtevaju autentifikaciju)
// Route::middleware('auth:api')->get('dogadjaji', [DogadjajController::class, 'index']);
// Route::middleware('auth:api')->get('dogadjaji/filter', [DogadjajController::class, 'filter']);

// // Rute zaštićene middleware-om 'auth:sanctum'
// Route::middleware('auth:sanctum')->group(function () {
//     // Ruta za prikaz autentifikovanog korisnika
//     Route::get('/user', function (Request $request) {
//         return $request->user();
//     });

//     // Dodatne rute za autentifikovane korisnike
//     Route::post('logout', [AuthController::class, 'logout']);
//     Route::post('korisnici/{korisnik}/promena-lozinke', [KorisnikController::class, 'promeniLozinku']);
//     Route::post('upload-fajlova', [FileController::class, 'store'])->name('upload.store');
//     Route::get('dogadjaji/external-data', [DogadjajController::class, 'fetchExternalData']);
//     Route::get('export-dogadjaji', [DogadjajController::class, 'export']);

//     // Resource rute
//     Route::apiResource('korisnici', KorisnikController::class);
//     Route::apiResource('dogadjaji', DogadjajController::class);
//     Route::apiResource('karte', KartaController::class);
//     Route::apiResource('tipovi-karata', TipKarteController::class);
//     Route::apiResource('placanja', PlacanjeController::class);

//     // Admin rute
//     Route::middleware(['role:admin'])->group(function () {
//         Route::post('/admin-create', [ApiController::class, 'create'])->name('api.admin.create');
//         Route::put('/admin-update', [ApiController::class, 'update'])->name('api.admin.update');
//         Route::delete('/admin-delete', [ApiController::class, 'delete'])->name('api.admin.delete');
//     });

//     // Autentifikovani korisnici
//     Route::middleware(['role:auth_user'])->group(function () {
//         Route::post('/purchase-tickets', [ApiController::class, 'purchaseTickets'])->name('api.purchase.tickets');
//         Route::post('/reserve-tickets', [ApiController::class, 'reserveTickets'])->name('api.reserve.tickets');
//     });
// });

// // Ruta za prikaz forme za upload fajlova (ako je potrebno)
// Route::get('upload-fajlova', [FileController::class, 'create'])->name('upload.create');

// // Ruta za čuvanje uploadovanih fajlova
// Route::post('upload-fajlova', [FileController::class, 'store'])->name('upload.store');

// Route::delete('clear-cache', function () {
//     Cache::forget('korisnici');
//     return response()->json(['message' => 'Cache cleared'], 200);
// });


// //filter
// Route::get('/dogadjaji/pretraga', [DogadjajController::class, 'pretraga'])->name('api.dogadjaji.pretraga');





























// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('/dogadjaji', [DogadjajController::class, 'index']);
//     Route::get('/dogadjaji/filter', [DogadjajController::class, 'filter']);
// });





// STARE, RAZBACANE I DUPLIRANE RUTE
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Resource ruta za CRUD operacije korisnika
Route::apiResource('korisnici', KorisnikController::class);
Route::apiResource('dogadjaji', DogadjajController::class);
Route::apiResource('karte', KartaController::class);
Route::apiResource('tipovi-karata', TipKarteController::class);
Route::apiResource('placanja', PlacanjeController::class);


// Ostali tipovi API ruta
Route::post('korisnici/{korisnik}/promena-lozinke', [KorisnikController::class, 'promeniLozinku']);
Route::post('upload-fajlova', [FileController::class, 'upload']);
Route::get('dogadjaji/external-data', [DogadjajController::class, 'fetchExternalData']);
Route::get('export-dogadjaji', [DogadjajController::class, 'export']);



Route::middleware('api')->group(function () {
    Route::apiResource('dogadjaji', DogadjajController::class);
});


// Rute za autentifikaciju
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

// Rute zaštićene middleware-om 'auth:sanctum'
Route::middleware('auth:sanctum')->group(function () {
    // Resource rute
    // Resource rute samo za autentifikovane korisnike
    Route::apiResource('korisnici', KorisnikController::class);
    Route::apiResource('dogadjaji', DogadjajController::class);
    Route::apiResource('karte', KartaController::class);
    Route::apiResource('tipovi-karata', TipKarteController::class);
    Route::apiResource('placanja', PlacanjeController::class);

    // Dodatne rute
    Route::post('korisnici/{korisnik}/promena-lozinke', [KorisnikController::class, 'promeniLozinku']);
    Route::post('upload-fajlova', [FileController::class, 'upload']);
    Route::get('dogadjaji/external-data', [DogadjajController::class, 'fetchExternalData']);
    Route::get('export-dogadjaji', [DogadjajController::class, 'export']);
});

Route::get('/guest-view-dogadjaj/{id}', [ApiController::class, 'showDogadjaj'])->name('api.guest.viewDogadjaj');
Route::get('/guest-view-dogadjaji', [ApiController::class, 'indexDogadjaji'])->name('api.guest.indexDogadjaji');

// Ruta za autentifikovanog korisnika
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// //rutta za paginaciju i filtriranje
Route::get('dogadjaji', [DogadjajController::class, 'index']);
Route::get('dogadjaji/filter', [DogadjajController::class, 'filter']);

// izmena zab loz
Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
//Route::post('reset-password', [AuthController::class, 'forgotPassword']); //
Route::post('reset-password', [AuthController::class, 'resetPassword']);


// resetovanje loz
// Route::get('password/reset/{token}', function ($token) {
//     return view('auth.reset-password', ['token' => $token]);
// })->name('password.reset');

Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'resetPassword']);



Route::middleware(['auth:sanctum'])->group(function () {
    Route::middleware(['role:admin'])->group(function () {
        Route::post('/admin-create', [ApiController::class, 'create'])->name('api.admin.create');
        Route::put('/admin-update', [ApiController::class, 'update'])->name('api.admin.update');
        Route::delete('/admin-delete', [ApiController::class, 'delete'])->name('api.admin.delete');
    });

    Route::middleware(['role:auth_user'])->group(function () {
        Route::post('/purchase-tickets', [ApiController::class, 'purchaseTickets'])->name('api.purchase.tickets');
        Route::post('/reserve-tickets', [ApiController::class, 'reserveTickets'])->name('api.reserve.tickets');
    });
});

Route::get('/guest-view', [ApiController::class, 'guestView'])->name('api.guest.view');

// Rute za autentifikaciju
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);


*/