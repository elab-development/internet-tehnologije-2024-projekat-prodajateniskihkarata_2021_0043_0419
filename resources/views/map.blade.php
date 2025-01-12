<!DOCTYPE html>
<html>
<head>
    <title>Leaflet Map</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 500px; /* Visina mape */
            width: 100%; /* Širina mape */
        }
    </style>
</head>
<body>
    <h1>Mapa</h1>
    <!-- Div u kojem će se prikazati mapa -->
    <div id="map"></div>
    <!-- Leaflet JavaScript biblioteka -->
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        // Funkcija za inicijalizaciju mape
        var map = L.map('map').setView([44.7866, 20.4489], 13); // Podesite centar mape ka Beogradu

        // Dodavanje OpenStreetMap sloja
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Dodavanje markera na mapu
        var marker = L.marker([44.7866, 20.4489]).addTo(map)
            .bindPopup('Beograd')
            .openPopup();
    </script>
</body>
</html>