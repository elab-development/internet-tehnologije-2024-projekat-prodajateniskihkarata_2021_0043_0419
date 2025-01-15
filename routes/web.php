<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DogadjajController;
use Illuminate\Http\Request;

use App\Http\Controllers\FileController;


use App\Http\Controllers\KorisnikController;

use App\Http\Controllers\KartaController;
use App\Http\Controllers\TipKarteController;
use App\Http\Controllers\PlacanjeController;

use App\Http\Controllers\AuthController;

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Cache;

use App\Http\Controllers\EksportController;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Http\Controllers\WeatherController;


Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');


Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/dogadjaji/pretraga', [DogadjajController::class, 'pretraga'])->name('dogadjaji.pretraga');

// Definisanje ruta za eksport podataka
Route::get('/eksport/csv', [EksportController::class, 'eksportCSV'])->name('eksport.csv');
Route::get('/eksport/ics', [EksportController::class, 'eksportICS'])->name('eksport.ics');
Route::get('/eksport/pdf', [EksportController::class, 'eksportPDF'])->name('eksport.pdf');


Route::get('/test-pdf', function () {
    $pdf = Pdf::loadHTML('<h1>Test PDF</h1>');
    return $pdf->download('test.pdf');
});

//VRE,E
Route::get('/weather', [WeatherController::class, 'getWeather'])->name('weather.get');

// MAPA
Route::get('/map', function () {
    return view('map');
})->name('map');

//VREME I MAPA
Route::get('/weather-map', [WeatherController::class, 'getWeatherAndMap'])->name('weather.map');


// Rute za paginaciju i filtriranje događaja (dostupne svima)
//Route::get('dogadjaji', [DogadjajController::class, 'index']);
//Route::get('dogadjaji/filter', [DogadjajController::class, 'filter']);



// Route::get('upload/create', [FileController::class, 'create'])->name('upload.create');
// Route::post('upload', [FileController::class, 'store'])->name('upload.store');