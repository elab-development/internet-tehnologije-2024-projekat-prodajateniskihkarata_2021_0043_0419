import React, { useState } from 'react';
import axios from 'axios';

const ForgotPassword = () => {
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
            setMessage('Reset password email sent. Please check your inbox.');
        } catch (error) {
            console.error('Error sending reset password email:', error);
            setMessage('Failed to send reset password email.');
        }
    };

    return (
        <div className="forgot-password-container">
            <h1>Forgot Password</h1>
            <form className="forgot-password-form" onSubmit={handleForgotPassword}>
                <div className="input-group">
                    <label>Email:</label>
                    <input
                        type="email"
                        name="email"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        className="email-input"
                        required
                    />
                </div>
                <button type="submit" className="forgot-password-button">Send Reset Link</button>
            </form>
            {message && <p>{message}</p>}
        </div>
    );
};

export default ForgotPassword;