import React from 'react';
import { useLanguage } from "../contexts/LanguageContext";
import BGO from './BGO.png';

const Home = () => {
    const { language } = useLanguage();

    const translations = {
        en: {
            welcome: "Welcome to the Belgrade Open Tournament",
            about: "The Belgrade Open is an annual tennis tournament held in Belgrade, Serbia. It attracts top tennis players from around the world and offers a fantastic opportunity for fans to see their favorite players compete live.",
            events: "Events",
            eventList: ["Men's Singles", "Women's Singles", "Men's Doubles", "Women's Doubles", "Mixed Doubles"],
            aboutTournament: "Founded in [Year], the Belgrade Open has quickly become one of the most anticipated events in the tennis calendar. With state-of-the-art facilities and a vibrant atmosphere, it offers an unforgettable experience for both players and spectators.",
            joinUs: "Join us for a week of thrilling matches, meet-and-greet sessions with players, and a variety of entertainment options for the whole family.",
            location: "Location",
            locationDetails: "The tournament takes place at the Belgrade Arena, one of the most modern sports venues in Eastern Europe. Easily accessible and equipped with world-class facilities, the arena provides an amazing atmosphere for both players and fans.",
            checkWeather: "🌤️ Check Weather in Belgrade",
        },
        sr: {
            welcome: "Dobrodošli na Belgrade Open turnir",
            about: "Belgrade Open je godišnji teniski turnir održan u Beogradu, Srbija. Okuplja vrhunske tenisere iz celog sveta i pruža fantastičnu priliku ljubiteljima sporta da uživo gledaju svoje omiljene igrače.",
            events: "Događaji",
            eventList: ["Muški singl", "Ženski singl", "Muški dubl", "Ženski dubl", "Mešoviti dubl"],
            aboutTournament: "Osnovan [godine], Belgrade Open je brzo postao jedan od najiščekivanijih turnira u teniskom kalendaru. Sa modernim objektima i dinamičnom atmosferom, nudi nezaboravno iskustvo kako igračima, tako i gledaocima.",
            joinUs: "Pridružite nam se na nedelji uzbudljivih mečeva, susreta sa igračima i raznovrsnih zabavnih sadržaja za celu porodicu.",
            location: "Lokacija",
            locationDetails: "Turnir se održava u Beogradskoj Areni, jednom od najmodernijih sportskih objekata u istočnoj Evropi. Lako dostupna i opremljena vrhunskim sadržajima, arena pruža neverovatnu atmosferu za igrače i navijače.",
            checkWeather: "🌤️ Proveri vreme u Beogradu",
        },
    };

    const handleWeatherClick = () => {
        window.open("http://localhost:8000/weather-map?city=Belgrade", "_blank");
    };

    return (
        <div className="home-container">
            <img 
                src={BGO} 
                alt="Belgrade Open Tournament" 
                className="home-image"
            />
            <h1>{translations[language].welcome}</h1>
            <p>{translations[language].about}</p>

            <h2>{translations[language].events}</h2>
            <ul>
                {translations[language].eventList.map((event, index) => (
                    <li key={index}>{event}</li>
                ))}
            </ul>

            <h2>{translations[language].location}</h2>
            <p>{translations[language].locationDetails}</p>

            <h2>About the Tournament</h2>
            <p>{translations[language].aboutTournament}</p>
            <p>{translations[language].joinUs}</p>

            {/* Dugme za vremensku prognozu */}
            <div className="weather-container">
                <button className="weather-button" onClick={handleWeatherClick}>
                    {translations[language].checkWeather}
                </button>
            </div>
        </div>
    );
};

export default Home;
