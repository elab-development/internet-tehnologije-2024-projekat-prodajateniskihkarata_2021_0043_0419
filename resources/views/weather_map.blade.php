<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hourly Weather Forecast</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
        .weather-info {
            margin-top: 20px;
        }
        .forecast-container {
            display: flex;
            overflow-x: auto;
            padding: 15px 0;
            gap: 15px;
            scrollbar-width: thin;
        }
        .forecast-container::-webkit-scrollbar {
            height: 8px;
        }
        .forecast-container::-webkit-scrollbar-thumb {
            background-color: #ccc;
            border-radius: 4px;
        }
        .forecast-container::-webkit-scrollbar-track {
            background-color: #f0f0f0;
        }
        .forecast-card {
            flex: 0 0 25%; /* Prikaz samo 4 kartice u jednom trenutku */
            max-width: 25%;
            min-width: 200px;
        }
        .forecast-card .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
        }
        .forecast-card h5 {
            font-size: 1rem;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center my-4">Weather and Map</h1>
        
        <!-- Map div -->
        <div id="map"></div>

        <!-- Weather information -->
        <div class="weather-info mt-4">
            <h2>Current Weather in {{ $city }}</h2>
            <div><strong>Temperature:</strong> {{ $weatherData['temperature'] }} °C</div>
            <div><strong>Description:</strong> {{ $weatherData['description'] }}</div>
            <div><strong>Humidity:</strong> {{ $weatherData['humidity'] }}%</div>
            <div><strong>Wind Speed:</strong> {{ $weatherData['wind_speed'] }} m/s</div>
            <div>
                <strong>Rain Probability:</strong> {{ $weatherData['rain_probability'] }}%<br>
                <!-- Dajemo verovatnoću padavina kao procenat -->
                <strong>Rain Intensity:</strong> {{ $weatherData['rain_intensity'] }} <!-- Npr. slabe, umerene, jake -->
            </div>
            <div><strong>Live Time:</strong> <span id="live-time"></span></div>

            <h2 class="mt-4">Hourly Weather Forecast</h2>
            <div class="forecast-container">
                @foreach($forecastData as $forecast)
                    <div class="forecast-card">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ \Carbon\Carbon::parse($forecast['date'])->format('H:i') }}</h5>
                                <p class="card-text">
                                    <strong>Temp:</strong> {{ $forecast['temperature'] }} °C<br>
                                    <strong>Desc:</strong> {{ $forecast['description'] }}<br>
                                    <strong>Rain:</strong> {{ $forecast['rain_probability'] }}% ({{ $forecast['rain_intensity'] }})
                                    <!-- Padavine u prognozi -->
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Initialize map (Beogradska Arena coordinates)
        var map = L.map('map').setView([44.8241, 20.4312], 13); // Koordinate Beogradske Arene

        // Add OpenStreetMap layer
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add marker
        var marker = L.marker([44.8141, 20.4212]).addTo(map) // Koordinate Beogradske Arene
            .bindPopup('Beogradska Arena')
            .openPopup();

        // Update live time
        function updateTime() {
            var now = new Date();
            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');
            var seconds = now.getSeconds().toString().padStart(2, '0');
            document.getElementById('live-time').innerHTML = hours + ':' + minutes + ':' + seconds;
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>
</html>
