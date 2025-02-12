import React, { createContext, useState, useEffect } from 'react';
import axios from 'axios';

export const UserContext = createContext();

export const UserProvider = ({ children }) => {
    const [user, setUser] = useState(null);

    useEffect(() => {
        // Proveri da li postoji token u localStorage
        const token = localStorage.getItem('token');
        if (token) {
            // Ako postoji token, dohvati korisničke podatke
            fetchUserData(token);
        }
    }, []);

    const fetchUserData = async (token) => {
        try {
            const response = await axios.get('http://localhost:8000/api/korisnik', {
                headers: {
                    'Authorization': `Bearer ${token}`
                }
            });
            console.log('Fetched user data:', response.data); // Dodajemo log
            setUser(response.data);
        } catch (error) {
            console.error('Error fetching user data:', error);
            // Ako dođe do greške, ukloni token i postavi user na null
            localStorage.removeItem('token');
            setUser(null);
        }
    };

    return (
        <UserContext.Provider value={{ user, setUser }}>
            {children}
        </UserContext.Provider>
    );
};