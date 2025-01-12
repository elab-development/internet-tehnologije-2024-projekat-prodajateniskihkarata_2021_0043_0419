<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;




class WeatherController extends Controller
{
    public function getWeather(Request $request)
    {
        $city = $request->input('city', 'Belgrade'); // Default city is Belgrade
        $apiKey = env('OPENWEATHERMAP_API_KEY'); // Get your API key from environment variables

        $client = new Client();
        $response = $client->get("http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric");

        $weatherData = json_decode($response->getBody(), true);

        // Obrađujemo podatke kako bismo ih prikazali u lepšem formatu
        $processedData = [
            'city' => $weatherData['name'],
            'temperature' => $weatherData['main']['temp'],
            'description' => $weatherData['weather'][0]['description'],
            'humidity' => $weatherData['main']['humidity'],
            'wind_speed' => $weatherData['wind']['speed']
        ];

        return view('weather', compact('processedData'));
    }

    // public function getWeatherAndMap(Request $request)
    // {
    //     $city = $request->input('city', 'Belgrade'); // Default city is Belgrade
    //     $apiKey = env('OPENWEATHERMAP_API_KEY'); // Get your API key from environment variables

    //     $client = new Client();
    //     $weatherResponse = $client->get("http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric");
    //     $forecastResponse = $client->get("http://api.openweathermap.org/data/2.5/forecast?q={$city}&appid={$apiKey}&units=metric");

    //     $weatherData = json_decode($weatherResponse->getBody(), true);
    //     $forecastData = json_decode($forecastResponse->getBody(), true);

    //     // Obrađujemo trenutne vremenske podatke kako bismo ih prikazali u lepšem formatu
    //     $processedWeatherData = [
    //         'temperature' => $weatherData['main']['temp'],
    //         'description' => $weatherData['weather'][0]['description'],
    //         'humidity' => $weatherData['main']['humidity'],
    //         'wind_speed' => $weatherData['wind']['speed']
    //     ];

    //     // Obrađujemo podatke vremenske prognoze kako bismo ih prikazali u lepšem formatu
    //     $processedForecastData = [];
    //     $today = date('Y-m-d');
    //     foreach ($forecastData['list'] as $forecast) {
    //         if (strpos($forecast['dt_txt'], $today) !== false) {
    //             $processedForecastData[] = [
    //                 'date' => $forecast['dt_txt'],
    //                 'temperature' => $forecast['main']['temp'],
    //                 'description' => $forecast['weather'][0]['description']
    //             ];
    //         }
    //     }

    //     return view('weather_map', [
    //         'city' => $city,
    //         'weatherData' => $processedWeatherData,
    //         'forecastData' => $processedForecastData
    //     ]);
    // }

    public function getWeatherAndMap(Request $request)
    {
        // Podaci o gradu, podrazumevano je Beograd
        $city = $request->input('city', 'Belgrade');
        $apiKey = env('OPENWEATHERMAP_API_KEY');

        // Kreiranje HTTP klijenta
        $client = new Client();

        // Prvi API poziv za trenutne vremenske podatke
        $weatherResponse = $client->get("http://api.openweathermap.org/data/2.5/weather?q={$city}&appid={$apiKey}&units=metric");

        // Drugi API poziv za vremensku prognozu
        $forecastResponse = $client->get("http://api.openweathermap.org/data/2.5/forecast?q={$city}&appid={$apiKey}&units=metric");

        // Parsiranje odgovora sa OpenWeatherMap
        $weatherData = json_decode($weatherResponse->getBody(), true);
        $forecastData = json_decode($forecastResponse->getBody(), true);

        // Obrada trenutnih vremenskih podataka
        $processedWeatherData = [
            'temperature' => $weatherData['main']['temp'],
            'description' => $weatherData['weather'][0]['description'],
            'humidity' => $weatherData['main']['humidity'],
            'wind_speed' => $weatherData['wind']['speed'],
            'rain_probability' => isset($weatherData['rain']) ? ($weatherData['rain']['1h'] > 0 ? 80 : 0) : 0, // Verovatnoća padavina
            'rain_intensity' => isset($weatherData['rain']) ? ($weatherData['rain']['1h'] > 0 ? 'Light' : 'None') : 'None' // Intenzitet padavina
        ];

        // Pravimo mapu podataka iz API-ja za prognozu
        $hourlyForecast = [];
        foreach ($forecastData['list'] as $forecast) {
            $forecastTime = Carbon::parse($forecast['dt_txt']);
            $hourlyForecast[$forecastTime->format('Y-m-d H:00:00')] = [
                'date' => $forecastTime->format('Y-m-d H:00:00'),
                'temperature' => $forecast['main']['temp'],
                'description' => $forecast['weather'][0]['description'],
                'rain_probability' => isset($forecast['rain']) ? ($forecast['rain']['3h'] > 0 ? 80 : 0) : 0, // Verovatnoća padavina za prognozu
                'rain_intensity' => isset($forecast['rain']) ? ($forecast['rain']['3h'] > 0 ? 'Moderate' : 'None') : 'None' // Intenzitet padavina
            ];
        }

        // Generisanje podataka za svaki sat tokom dana
        $currentTime = Carbon::now();
        $startTime = $currentTime->format('Y-m-d H:00:00'); // Početak od trenutnog sata
        $endTime = $currentTime->copy()->endOfDay(); // Do kraja dana

        $processedForecastData = [];
        for ($time = Carbon::parse($startTime); $time->lessThanOrEqualTo($endTime); $time->addHour()) {
            $formattedTime = $time->format('Y-m-d H:00:00');

            if (isset($hourlyForecast[$formattedTime])) {
                $processedForecastData[] = $hourlyForecast[$formattedTime];
            } else {
                // Pronađi prethodnu i sledeću tačku za interpolaciju
                $previous = collect($hourlyForecast)->filter(function ($value, $key) use ($formattedTime) {
                    return $key < $formattedTime;
                })->last();

                $next = collect($hourlyForecast)->filter(function ($value, $key) use ($formattedTime) {
                    return $key > $formattedTime;
                })->first();

                if ($previous && $next) {
                    $timeDiff = Carbon::parse($next['date'])->diffInHours(Carbon::parse($previous['date']));
                    $tempDiff = ($next['temperature'] - $previous['temperature']) / $timeDiff;
                    $temp = $previous['temperature'] + $tempDiff * Carbon::parse($previous['date'])->diffInHours($time);

                    $processedForecastData[] = [
                        'date' => $formattedTime,
                        'temperature' => round($temp, 1),
                        'description' => $previous['description'], // Zadržavamo opis od prethodne tačke
                        'rain_probability' => rand(0, 100), // Generisanje slučajne verovatnoće za interpolaciju
                        'rain_intensity' => 'Moderate' // Intenzitet padavina za interpolaciju
                    ];
                }
            }
        }

        // Vraćanje podataka u view
        return view('weather_map', [
            'city' => $city,
            'weatherData' => $processedWeatherData,
            'forecastData' => $processedForecastData
        ]);
    }



}
