import React, { useState } from 'react';
import axios from 'axios';
import { useLanguage } from '../contexts/LanguageContext'; // Importujemo useLanguage
import './passwords.css';

const ForgotPassword = () => {
    const { language } = useLanguage(); // Koristimo language iz context-a
    const [email, setEmail] = useState('');
    const [message, setMessage] = useState('');

    const handleForgotPassword = async (e) => {
        e.preventDefault();
        try {
            const response = await axios.post('http://localhost:8000/api/forgot-password', {
                email: email
            }, {
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            setMessage(translations[language].emailSentMessage); // Uspešan odgovor
        } catch (error) {
            console.error('Error sending reset password email:', error);
            setMessage(translations[language].emailFailedMessage); // Neuspešno slanje
        }
    };

    // Definisanje prevoda
    const translations = {
        en: {
            forgotPasswordPage: "Forgot Password",
            email: "Email",
            sendResetLink: "Send Reset Link",
            emailSentMessage: "Reset password email sent. Please check your inbox.",
            emailFailedMessage: "Failed to send reset password email."
        },
        sr: {
            forgotPasswordPage: "Zaboravljena lozinka",
            email: "Email",
            sendResetLink: "Pošaljite link za resetovanje",
            emailSentMessage: "Email za resetovanje lozinke je poslat. Molimo proverite svoj inbox.",
            emailFailedMessage: "Neuspešno slanje email-a za resetovanje lozinke."
        }
    };

    return (
        <div className="forgot-password-container">
            <h1>{translations[language].forgotPasswordPage}</h1>
            <form className="forgot-password-form" onSubmit={handleForgotPassword}>
                <div className="input-group">
                    <label>{translations[language].email}:</label>
                    <input
                        type="email"
                        name="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        className="email-input"
                        required
                    />
                </div>
                <button type="submit" className="forgot-password-button">
                    {translations[language].sendResetLink}
                </button>
            </form>
            {message && <p>{message}</p>}
        </div>
    );
};

export default ForgotPassword;
