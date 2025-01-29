import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useSearchParams } from 'react-router-dom';
import './passwords.css';

const ResetPassword = () => {
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
                    <label>Confirm New Password:</label>
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
                <button type="submit" className="reset-password-button">Reset Password</button>
            </form>
            {message && <p>{message}</p>}
        </div>
    );
};

export default ResetPassword;
