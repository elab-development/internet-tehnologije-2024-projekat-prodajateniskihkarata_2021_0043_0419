import React, { useState, useContext } from 'react';
import { Link } from 'react-router-dom';
import { UserContext } from '../contexts/UserContext';

const NavBar = () => {
    const { user, setUser } = useContext(UserContext);
    const [isOpen, setIsOpen] = useState(false);
    const [dropdownOpen, setDropdownOpen] = useState(false);

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
                <Link to="/">Home</Link>
                <Link to="/matches">Matches</Link>
                <Link to="/buy-ticket">Buy Ticket</Link>
                <Link to="/contact">Contact</Link>
                {user && (
                    <div className="user-menu user-menu-mobile">
                        <span className="user-name" onClick={toggleDropdown}>
                            {user.ime}
                        </span>
                        {dropdownOpen && (
                            <div className="dropdown-menu">
                                <Link to="/change-password" onClick={toggleDropdown}>Change Password</Link>
                                <Link to="/" onClick={handleLogout}>Logout</Link>
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
                                <Link to="/change-password" onClick={toggleDropdown}>Change Password</Link>
                                <Link to="/" onClick={handleLogout}>Logout</Link>
                            </div>
                        )}
                    </div>
                ) : (
                    <>
                        <Link to="/login">Login</Link>
                        <Link to="/register">Register</Link>
                    </>
                )}
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
                    {user ? (
                        <>
                            <Link to="/change-password" onClick={toggleMenu}>Change Password</Link>
                            <Link to="/" onClick={() => { handleLogout(); toggleMenu(); }}>Logout</Link>
                        </>
                    ) : (
                        <>
                            <Link to="/login" onClick={toggleMenu}>Login</Link>
                            <Link to="/register" onClick={toggleMenu}>Register</Link>
                        </>
                    )}
                </div>
            )}
        </nav>
    );
};

export default NavBar;