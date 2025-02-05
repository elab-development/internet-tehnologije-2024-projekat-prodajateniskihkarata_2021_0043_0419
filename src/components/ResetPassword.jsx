import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useSearchParams } from 'react-router-dom';
import { useLanguage } from '../contexts/LanguageContext'; // Importujemo useLanguage
import './passwords.css';

const ResetPassword = () => {
    const { language } = useLanguage(); // Koristimo language iz context-a
    const [searchParams] = useSearchParams();
    const [password, setPassword] = useState('');
    const [passwordConfirmation, setPasswordConfirmation] = useState('');
    const [message, setMessage] = useState('');
    const [showPassword, setShowPassword] = useState(false);
    const [showPasswordConfirmation, setShowPasswordConfirmation] = useState(false);

    const token = searchParams.get('token');
    const userId = searchParams.get('userId');

    const handleResetPassword = async (e) => {
        e.preventDefault();
        try {
            await axios.post('http://localhost:8000/api/reset-password', {
                password: password,
                password_confirmation: passwordConfirmation,
                token: token,
                userId: userId
            });
            setMessage(translations[language].resetSuccessMessage);
        } catch (error) {
            console.error('Error resetting password:', error);
            setMessage(translations[language].resetFailureMessage);
        }
    };

    // Definisanje prevoda
    const translations = {
        en: {
            resetPasswordPage: "Reset Password",
            newPassword: "New Password",
            confirmNewPassword: "Confirm New Password",
            resetPasswordButton: "Reset Password",
            resetSuccessMessage: "Password reset successfully. You can now login with your new password.",
            resetFailureMessage: "Failed to reset password. Please try again."
        },
        sr: {
            resetPasswordPage: "Resetovanje lozinke",
            newPassword: "Nova lozinka",
            confirmNewPassword: "Potvrdi novu lozinku",
            resetPasswordButton: "Resetuj lozinku",
            resetSuccessMessage: "Lozinka je uspešno resetovana. Sada se možete prijaviti sa novom lozinkom.",
            resetFailureMessage: "Neuspešno resetovanje lozinke. Pokušajte ponovo."
        }
    };

    return (
        <div className="reset-password-container">
            <h1>{translations[language].resetPasswordPage}</h1>
            <form className="reset-password-form" onSubmit={handleResetPassword}>
                <div className="input-group">
                    <label>{translations[language].newPassword}:</label>
                    <div className="password-input-wrapper">
                        <input
                            type={showPassword ? "text" : "password"}
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                            className="password-input"
                            required
                        />
                        <span className="toggle-password" onClick={() => setShowPassword(!showPassword)}>
                            {showPassword ? "🙈" : "👁️"}
                        </span>
                    </div>
                </div>
                <div className="input-group">
                    <label>{translations[language].confirmNewPassword}:</label>
                    <div className="password-input-wrapper">
                        <input
                            type={showPasswordConfirmation ? "text" : "password"}
                            value={passwordConfirmation}
                            onChange={(e) => setPasswordConfirmation(e.target.value)}
                            className="password-confirmation-input"
                            required
                        />
                        <span className="toggle-password" onClick={() => setShowPasswordConfirmation(!showPasswordConfirmation)}>
                            {showPasswordConfirmation ? "🙈" : "👁️"}
                        </span>
                    </div>
                </div>
                <button type="submit" className="reset-password-button">{translations[language].resetPasswordButton}</button>
            </form>
            {message && <p>{message}</p>}
        </div>
    );
};

export default ResetPassword;
