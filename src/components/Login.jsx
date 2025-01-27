import React, { useState } from 'react';
import { Link } from 'react-router-dom'; // Pretpostavljamo da koristite react-router-dom za navigaciju
import axios from 'axios';

const Login = () => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [showPassword, setShowPassword] = useState(false);

    const toggleShowPassword = () => {
        setShowPassword(!showPassword);
    };

    const handleLogin = async (e) => {
        e.preventDefault();
        try {
            const response = await axios.post('http://localhost:8000/api/login', {
                email: email,
                lozinka: password
            }, {
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            console.log(response.data);
            alert('Login successful');
            // Save the token to local storage or context
            localStorage.setItem('token', response.data.access_token);
        } catch (error) {
            console.error('Error logging in:', error);
            if (error.response && error.response.status === 401) {
                alert('Invalid credentials. Please check your email and password and try again.');
            } else {
                alert('Login failed. Please try again later.');
            }
        }
    };

    return (
        <div className="login-container">
            <h1>Login Page</h1>
            <form className="login-form" onSubmit={handleLogin}>
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
                <div className="input-group password-field">
                    <label>Password:</label>
                    <div className="password-input-wrapper">
                        <input
                            type={showPassword ? "text" : "password"}
                            name="password"
                            value={password}
                            onChange={(e) => setPassword(e.target.value)}
                            className="password-input"
                            required
                        />
                        <span className="toggle-password" onClick={toggleShowPassword}>
                            {showPassword ? "🙈" : "👁️"}
                        </span>
                    </div>
                </div>
                <button type="submit" className="login-button">Login</button>
            </form>
            <div className="register-link">
                <p>Don't have an account? <Link to="/register">Register here</Link></p>
            </div>
            <div className="forgot-password-link">
                <p>Forgot your password? <Link to="/forgot-password">Reset it here</Link></p>
            </div>
        </div>
    );
};

export default Login;



// import React, { useState } from 'react';

// const Login = () => {
//     const [showPassword, setShowPassword] = useState(false);

//     const toggleShowPassword = () => {
//         setShowPassword(!showPassword);
//     };

//     return (
//         <div className="login-container">
//             <h1>Login Page</h1>
//             <form className="login-form">
//                 <div className="input-group">
//                     <label>Email:</label>
//                     <input type="email" name="email" className="email-input" required />
//                 </div>
//                 <div className="input-group password-field">
//                     <label>Password:</label>
//                     <div className="password-input-wrapper">
//                         <input type={showPassword ? "text" : "password"} name="password" className="password-input" required />
//                         <span className="toggle-password" onClick={toggleShowPassword}>
//                             {showPassword ? "🙈" : "👁️"}
//                         </span>
//                     </div>
//                 </div>
//                 <button type="submit" className="login-button">Login</button>
//             </form>
//         </div>
//     );
// };

// export default Login;