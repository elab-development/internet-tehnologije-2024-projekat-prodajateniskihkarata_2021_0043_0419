import React, { useState, useContext } from 'react';
import { Link } from 'react-router-dom';
import { UserContext } from '../contexts/UserContext';
import { useLanguage } from '../contexts/LanguageContext'; // Dodata podrška za jezike

const NavBar = () => {
    const { user, setUser } = useContext(UserContext);
    const { language } = useLanguage(); // Koristi language iz context-a

    const [isOpen, setIsOpen] = useState(false);
    const [dropdownOpen, setDropdownOpen] = useState(false);

    const translations = {
        en: {
            home: "Home",
            matches: "Matches",
            buyTicket: "Buy Ticket",
            contact: "Contact",
            users: "Users",
            payment: "Payment",
            changePassword: "Change Password",
            logout: "Logout",
            login: "Login",
            register: "Register"
        },
        sr: {
            home: "Početna",
            matches: "Mečevi",
            buyTicket: "Kupovina karte",
            contact: "Kontakt",
            users: "Korisnici",
            payment: "Plaćanja",
            changePassword: "Promeni lozinku",
            logout: "Odjava",
            login: "Prijava",
            register: "Registracija"
        }
    };

    const toggleMenu = () => {
        setIsOpen(!isOpen);
    };

    const toggleDropdown = () => {
        setDropdownOpen(!dropdownOpen);
    };

    const handleLogout = () => {
        localStorage.removeItem('token');
        setUser(null);
    };

    return (
        <nav className="navbar">
            <div className="navbar-left">
                <Link to="/">{translations[language].home}</Link>
                <Link to="/matches">{translations[language].matches}</Link>
                <Link to="/buy-ticket">{translations[language].buyTicket}</Link>
                <Link to="/contact">{translations[language].contact}</Link>
                {user && user.uloga === "admin" && <Link to="/users">{translations[language].users}</Link>}
                {user && user.uloga === "admin" && <Link to="/payments">{translations[language].payment}</Link>}
                {user && (
                    <div className="user-menu user-menu-mobile">
                        <span className="user-name" onClick={toggleDropdown}>
                            {user.ime}
                        </span>
                        {dropdownOpen && (
                            <div className="dropdown-menu">
                                <Link to="/change-password" onClick={toggleDropdown}>{translations[language].changePassword}</Link>
                                <Link to="/" onClick={handleLogout}>{translations[language].logout}</Link>
                            </div>
                        )}
                    </div>
                )}
            </div>
            <div className="navbar-right">
                {user ? (
                    <div className="user-menu user-menu-desktop">
                        <span className="user-name" onClick={toggleDropdown}>
                            {user.ime}
                        </span>
                        {dropdownOpen && (
                            <div className="dropdown-menu">
                                <Link to="/change-password" onClick={toggleDropdown}>{translations[language].changePassword}</Link>
                                <Link to="/" onClick={handleLogout}>{translations[language].logout}</Link>
                            </div>
                        )}
                    </div>
                ) : (
                    <>
                        <Link to="/login">{translations[language].login}</Link>
                        <Link to="/register">{translations[language].register}</Link>
                    </>
                )}
            </div>
            <div className="hamburger" onClick={toggleMenu}>
                &#9776;
            </div>
            {isOpen && (
                <div className="dropdown-menu">
                    <Link to="/" onClick={toggleMenu}>{translations[language].home}</Link>
                    <Link to="/matches" onClick={toggleMenu}>{translations[language].matches}</Link>
                    <Link to="/buy-ticket" onClick={toggleMenu}>{translations[language].buyTicket}</Link>
                    <Link to="/contact" onClick={toggleMenu}>{translations[language].contact}</Link>
                    {user && user.uloga === "admin" && <Link to="/users" onClick={toggleMenu}>{translations[language].users}</Link>} 
                    {user && user.uloga === "admin" && <Link to="/payment" onClick={toggleMenu}>{translations[language].payment}</Link>} 
                    {user ? (
                        <>
                            <Link to="/change-password" onClick={toggleMenu}>{translations[language].changePassword}</Link>
                            <Link to="/" onClick={() => { handleLogout(); toggleMenu(); }}>{translations[language].logout}</Link>
                        </>
                    ) : (
                        <>
                            <Link to="/login" onClick={toggleMenu}>{translations[language].login}</Link>
                            <Link to="/register" onClick={toggleMenu}>{translations[language].register}</Link>
                        </>
                    )}
                </div>
            )}
        </nav>
    );
};

export default NavBar;
