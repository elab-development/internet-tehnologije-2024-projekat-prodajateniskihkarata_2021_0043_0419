import React, { useState } from 'react';
import { Link } from 'react-router-dom';

const NavBar = () => {
    const [isOpen, setIsOpen] = useState(false);

    const toggleMenu = () => {
        setIsOpen(!isOpen);
    };

    return (
        <nav className="navbar">
            <div className="navbar-left">
                <Link to="/">Home</Link>
                <Link to="/matches">Matches</Link>
                <Link to="/buy-ticket">Buy Ticket</Link>
                <Link to="/contact">Contact</Link>
            </div>
            <div className="navbar-right">
                <Link to="/login">Login</Link>
                <Link to="/register">Register</Link>
            </div>
            <div className="hamburger" onClick={toggleMenu}>
                &#9776;
            </div>
            {isOpen && (
                <div className="dropdown-menu">
                    <Link to="/" onClick={toggleMenu}>Home</Link>
                    <Link to="/matches" onClick={toggleMenu}>Matches</Link>
                    <Link to="/buy-ticket" onClick={toggleMenu}>Buy Ticket</Link>
                    <Link to="/contact" onClick={toggleMenu}>Contact</Link>
                    <Link to="/login" onClick={toggleMenu}>Login</Link>
                    <Link to="/register" onClick={toggleMenu}>Register</Link>
                </div>
            )}
        </nav>
    );
};

export default NavBar;
