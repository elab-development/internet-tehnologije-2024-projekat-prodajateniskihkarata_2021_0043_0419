<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;


use App\Http\Controllers\KorisnikController;
use App\Http\Controllers\DogadjajController;
use App\Http\Controllers\KartaController;
use App\Http\Controllers\TipKarteController;
use App\Http\Controllers\PlacanjeController;

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

