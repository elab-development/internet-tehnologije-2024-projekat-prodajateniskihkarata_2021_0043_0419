import React from 'react';
//import './Home.css'; // Kreirajte i povežite CSS fajl za stilizovanje
import BGO from './/BGO.png';

const Home = () => {
    return (
        <div className="home-container">
            <img 
                src={BGO} 
                alt="Belgrade Open Tournament" 
                className="home-image"
            />
            <h1>Welcome to the Belgrade Open Tournament</h1>
            <p>
                The Belgrade Open is an annual tennis tournament held in Belgrade, Serbia. 
                It attracts top tennis players from around the world and offers a fantastic 
                opportunity for fans to see their favorite players compete live.
            </p>
            <h2>Events</h2>
            <ul>
                <li>Men's Singles</li>
                <li>Women's Singles</li>
                <li>Men's Doubles</li>
                <li>Women's Doubles</li>
                <li>Mixed Doubles</li>
            </ul>
            <h2>About the Tournament</h2>
            <p>
                Founded in [Year], the Belgrade Open has quickly become one of the most 
                anticipated events in the tennis calendar. With state-of-the-art facilities 
                and a vibrant atmosphere, it offers an unforgettable experience for both 
                players and spectators.
            </p>
            <p>
                Join us for a week of thrilling matches, meet-and-greet sessions with 
                players, and a variety of entertainment options for the whole family.
            </p>
        </div>
    );
};

export default Home;