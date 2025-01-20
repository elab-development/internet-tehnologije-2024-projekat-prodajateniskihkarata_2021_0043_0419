import React, { useState } from 'react';

const Login = () => {
    const [showPassword, setShowPassword] = useState(false);

    const toggleShowPassword = () => {
        setShowPassword(!showPassword);
    };

    return (
        <div className="login-container">
            <h1>Login Page</h1>
            <form className="login-form">
                <div className="input-group">
                    <label>Email:</label>
                    <input type="email" name="email" className="email-input" required />
                </div>
                <div className="input-group password-field">
                    <label>Password:</label>
                    <div className="password-input-wrapper">
                        <input type={showPassword ? "text" : "password"} name="password" className="password-input" required />
                        <span className="toggle-password" onClick={toggleShowPassword}>
                            {showPassword ? "🙈" : "👁️"}
                        </span>
                    </div>
                </div>
                <button type="submit" className="login-button">Login</button>
            </form>
        </div>
    );
};

export default Login;