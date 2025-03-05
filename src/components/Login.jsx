import React, { useState, useContext } from 'react';
import { Link, useNavigate } from 'react-router-dom';
import axios from 'axios';
import { UserContext } from '../contexts/UserContext';
import { useLanguage } from '../contexts/LanguageContext';

const Login = () => {
    const { setUser } = useContext(UserContext);
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [showPassword, setShowPassword] = useState(false);
    const navigate = useNavigate();
    const { language } = useLanguage(); // Koristi language iz context-a

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
            alert(translations[language].loginSuccess);
            // Save the token to local storage or context
            localStorage.setItem('token', response.data.access_token);
            setUser(response.data.user);
            navigate('/');
        } catch (error) {
            console.error('Error logging in:', error);
            if (error.response && error.response.status === 401) {
                alert(translations[language].invalidCredentials);
            } else {
                alert(translations[language].loginFailed);
            }
        }
    };

    const translations = {
        en: {
            loginPage: "Login Page",
            email: "Email",
            password: "Password",
            login: "Login",
            question1: "Don't have an account?",
            registerHere: "Register here",
            question2: "Forgot your password?",
            resetPassword: "Reset it here",
            loginSuccess: "Login successful",
            invalidCredentials: "Invalid credentials. Please check your email and password and try again.",
            loginFailed: "Login failed. Please try again later."
        },
        sr: {
            loginPage: "Stranica za prijavu",
            email: "Email",
            password: "Lozinka",
            login: "Prijavite se",
            question1: "Nemate nalog?",
            registerHere: "Registrujte se ovde",
            question2: "Zaboravili ste lozinku?",
            resetPassword: "Resetujte je ovde",
            loginSuccess: "Prijava uspešna",
            invalidCredentials: "Neispravni podaci. Proverite email i lozinku i pokušajte ponovo.",
            loginFailed: "Prijava nije uspela. Pokušajte ponovo kasnije."
        }
    };

    return (
        <div className="login-container">
            <h1>{translations[language].loginPage}</h1>
            <form className="login-form" onSubmit={handleLogin}>
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
                <div className="input-group password-field">
                    <label>{translations[language].password}:</label>
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
                <button type="submit" className="login-button">{translations[language].login}</button>
            </form>

            {/* Tekst i link za registraciju */}
            <div className="register-link">
                <p>{translations[language].question1} <Link to="/register">{translations[language].registerHere}</Link></p>
            </div>

            {/* Tekst i link za zaboravljenu lozinku */}
            <div className="forgot-password-link">
            <p>{translations[language].question2} <Link to="/forgot-password">{translations[language].resetPassword}</Link></p>
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