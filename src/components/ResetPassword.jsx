// ResetPassword.jsx
import React, { useState, useEffect } from 'react';
import axios from 'axios';
import Cookies from 'js-cookie';

const ResetPassword = () => {
    const [token, setToken] = useState('');
    const [password, setPassword] = useState('');
    const [passwordConfirmation, setPasswordConfirmation] = useState('');
    const [message, setMessage] = useState('');

    useEffect(() => {
        // Dohvatanje tokena iz kolačića
        const token = Cookies.get('password_reset_token');
        if (token) {
            setToken(token);
        } else {
            setMessage('No token found. Please request a new password reset.');
        }
    }, []);

    const handleResetPassword = async (e) => {
        e.preventDefault();
        try {
            const response = await axios.post('http://localhost:8000/api/reset-password', {
                password: password,
                password_confirmation: passwordConfirmation,
                token: token
            });
            setMessage('Password reset successfully. You can now login with your new password.');
        } catch (error) {
            console.error('Error resetting password:', error);
            setMessage('Failed to reset password. Please try again.');
        }
    };

    return (
        <div className="reset-password-container">
            <h1>Reset Password</h1>
            <form className="reset-password-form" onSubmit={handleResetPassword}>
                <div className="input-group">
                    <label>New Password:</label>
                    <input
                        type="password"
                        name="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        className="password-input"
                        required
                    />
                </div>
                <div className="input-group">
                    <label>Confirm New Password:</label>
                    <input
                        type="password"
                        name="passwordConfirmation"
                        value={passwordConfirmation}
                        onChange={(e) => setPasswordConfirmation(e.target.value)}
                        className="password-confirmation-input"
                        required
                    />
                </div>
                <button type="submit" className="reset-password-button">Reset Password</button>
            </form>
            {message && <p>{message}</p>}
        </div>
    );
};

export default ResetPassword;