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



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('korisnici', KorisnikController::class);
Route::apiResource('dogadjaji', DogadjajController::class);
Route::apiResource('karte', KartaController::class);
Route::apiResource('tipovi-karata', TipKarteController::class);
Route::apiResource('placanja', PlacanjeController::class);

Route::post('korisnici/{korisnik}/promena-lozinke', [KorisnikController::class, 'promeniLozinku']);

Route::post('upload-fajlova', [FileController::class, 'upload']);

Route::get('dogadjaji/external-data', [DogadjajController::class, 'fetchExternalData']);

Route::get('export-dogadjaji', [DogadjajController::class, 'export']);



// Route::middleware('api')->group(function () {
//     Route::apiResource('dogadjaji', DogadjajController::class);
// });


// Rute za autentifikaciju
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    // Resource rute
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



// Route::middleware(['auth:sanctum'])->group(function () {
//     Route::middleware(['role:admin'])->group(function () {
//         Route::post('/admin-create', [ApiController::class, 'create'])->name('api.admin.create');
//         Route::put('/admin-update', [ApiController::class, 'update'])->name('api.admin.update');
//         Route::delete('/admin-delete', [ApiController::class, 'delete'])->name('api.admin.delete');
//     });

//     Route::middleware(['role:auth_user'])->group(function () {
//         Route::post('/purchase-tickets', [ApiController::class, 'purchaseTickets'])->name('api.purchase.tickets');
//         Route::post('/reserve-tickets', [ApiController::class, 'reserveTickets'])->name('api.reserve.tickets');
//     });
// });

// Route::get('/guest-view', [ApiController::class, 'guestView'])->name('api.guest.view');

// // Rute za autentifikaciju
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/register', [AuthController::class, 'register']);
