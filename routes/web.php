<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DogadjajController;
use App\Http\Controllers\KartaController;
use App\Http\Controllers\UploadController;

Route::get('/', function () {
    return view('welcome');
});


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::get('/dogadjaji', [DogadjajController::class, 'index']);
Route::get('/dogadjaji/{id}', [DogadjajController::class, 'show']);
Route::post('/dogadjaji', [DogadjajController::class, 'store']);
Route::put('/dogadjaji/{id}', [DogadjajController::class, 'update']);
Route::delete('/dogadjaji/{id}', [DogadjajController::class, 'destroy']);

// Slične rute kreiramo za karte
Route::get('/karte', [KartaController::class, 'index']);
Route::get('/karte/{id}', [KartaController::class, 'show']);
Route::post('/karte', [KartaController::class, 'store']);
Route::put('/karte/{id}', [KartaController::class, 'update']);
Route::delete('/karte/{id}', [KartaController::class, 'destroy']);

Route::post('/reset-password', [AuthController::class, 'resetPassword']);

Route::post('/upload', [UploadController::class, 'upload']);

Route::get('/dogadjaji/export/csv', [DogadjajController::class, 'exportCsv']);

