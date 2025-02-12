import React, { useEffect, useState } from "react";
import { MapContainer, TileLayer, Marker, Popup } from "react-leaflet";
import "leaflet/dist/leaflet.css";
import "./WeatherMap.css"; // Napravi ovaj fajl za stilove

const WeatherMap = () => {
    const [weatherData, setWeatherData] = useState(null);
    const [forecastData, setForecastData] = useState([]);
    
    useEffect(() => {
        // Ovde pozivamo Laravel API
        fetch("http://localhost:8000/api/weather?city=Belgrade")
            .then((response) => response.json())
            .then((data) => {
                setWeatherData(data.weatherData);
                setForecastData(data.forecastData);
            })
            .catch((error) => console.error("Error fetching weather data:", error));
    }, []);

    return (
        <div className="weather-map-container">
            <h1>Weather and Map</h1>

            {/* Mapa */}
            <MapContainer center={[44.8241, 20.4312]} zoom={13} className="map">
                <TileLayer
                    url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                    attribution='&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                />
                <Marker position={[44.8141, 20.4212]}>
                    <Popup>Beogradska Arena</Popup>
                </Marker>
            </MapContainer>

            {/* Prikaz vremena */}
            {weatherData && (
                <div className="weather-info">
                    <h2>Current Weather in Belgrade</h2>
                    <p><strong>Temperature:</strong> {weatherData.temperature} °C</p>
                    <p><strong>Description:</strong> {weatherData.description}</p>
                    <p><strong>Humidity:</strong> {weatherData.humidity}%</p>
                    <p><strong>Wind Speed:</strong> {weatherData.wind_speed} m/s</p>
                    <p><strong>Rain Probability:</strong> {weatherData.rain_probability}%</p>
                    <p><strong>Rain Intensity:</strong> {weatherData.rain_intensity}</p>
                </div>
            )}

            {/* Satna prognoza */}
            <h2>Hourly Weather Forecast</h2>
            <div className="forecast-container">
                {forecastData.map((forecast, index) => (
                    <div className="forecast-card" key={index}>
                        <div className="card">
                            <div className="card-body">
                                <h5 className="card-title">{forecast.time}</h5>
                                <p className="card-text">
                                    <strong>Temp:</strong> {forecast.temperature} °C<br />
                                    <strong>Desc:</strong> {forecast.description}<br />
                                    <strong>Rain:</strong> {forecast.rain_probability}% ({forecast.rain_intensity})
                                </p>
                            </div>
                        </div>
                    </div>
                ))}
            </div>
        </div>
    );
};

export default WeatherMap;
