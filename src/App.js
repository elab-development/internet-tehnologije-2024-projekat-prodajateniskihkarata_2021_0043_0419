import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import Home from './components/Home';
import Matches from './components/Matches';
import BuyTicket from './components/BuyTicket';
import Login from './components/Login';
import Register from './components/Register';
import Contact from './components/Contact';
import NavBar from './components/NavBar';

import './App.css'; // Import CSS for general styling

function App() {
    return (
        <Router>
            <NavBar />
            <Routes>
                <Route path="/" element={<Home />} />
                <Route path="/matches" element={<Matches />} />
                <Route path="/buy-ticket" element={<BuyTicket />} />
                <Route path="/login" element={<Login />} />
                <Route path="/register" element={<Register />} />
                <Route path="/contact" element={<Contact />} />
            </Routes>
        </Router>
    );
}

export default App;