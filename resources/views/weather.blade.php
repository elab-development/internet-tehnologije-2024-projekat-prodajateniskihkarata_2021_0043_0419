<!DOCTYPE html>
<html>
<head>
    <title>Weather Data</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #343a40;
        }
        .weather-info {
            margin-top: 20px;
        }
        .weather-info div {
            margin: 10px 0;
        }
        .weather-info div strong {
            color: #343a40;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Weather in {{ $processedData['city'] }}</h1>
        <div class="weather-info">
            <div><strong>Temperature:</strong> {{ $processedData['temperature'] }} °C</div>
            <div><strong>Description:</strong> {{ $processedData['description'] }}</div>
            <div><strong>Humidity:</strong> {{ $processedData['humidity'] }}%</div>
            <div><strong>Wind Speed:</strong> {{ $processedData['wind_speed'] }} m/s</div>
        </div>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>