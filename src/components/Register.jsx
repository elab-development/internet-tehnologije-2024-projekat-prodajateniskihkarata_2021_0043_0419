import React, { useState } from 'react';
import { Link, useNavigate } from 'react-router-dom'; // Dodajemo useNavigate
import axios from 'axios';
import { useLanguage } from '../contexts/LanguageContext'; // Dodajemo useLanguage kontekst za prevođenje

const Register = () => {
  const { language } = useLanguage(); // Koristimo language iz context-a
  const navigate = useNavigate(); // Inicijalizujemo navigate
  const [username, setUsername] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [confirmPassword, setConfirmPassword] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [showConfirmPassword, setShowConfirmPassword] = useState(false);
  const [passwordError, setPasswordError] = useState('');
  const [matchError, setMatchError] = useState('');

  const toggleShowPassword = () => {
    setShowPassword(!showPassword);
  };

  const toggleShowConfirmPassword = () => {
    setShowConfirmPassword(!showConfirmPassword);
  };

  const validatePassword = (value) => {
    const minLength = 8;
    const hasUppercase = /[A-Z]/.test(value);
    const hasLowercase = /[a-z]/.test(value);
    const hasNumber = /[0-9]/.test(value);
    const hasSpecialChar = /[@$!%*?&#]/.test(value);

    if (!value) {
      return "Password is required";
    }
    if (value.length < minLength) {
      return `Password must be at least ${minLength} characters long`;
    }
    if (!hasUppercase) {
      return "Password must contain at least one uppercase letter";
    }
    if (!hasLowercase) {
      return "Password must contain at least one lowercase letter";
    }
    if (!hasNumber) {
      return "Password must contain at least one number";
    }
    if (!hasSpecialChar) {
      return "Password must contain at least one special character (@$!%*?&#)";
    }
    return "";
  };

  const handlePasswordChange = (e) => {
    const value = e.target.value;
    setPassword(value);
    setPasswordError(validatePassword(value));
  };

  const handleConfirmPasswordChange = (e) => {
    const value = e.target.value;
    setConfirmPassword(value);
    setMatchError(value !== password ? "Passwords do not match" : "");
  };

  const calculatePasswordStrength = () => {
    let strength = 0;
    if (password.length >= 8) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) strength++;
    return strength;
  };

  const renderStrengthBar = () => {
    const strength = calculatePasswordStrength();
    const strengthLabels = ["Weak", "Fair", "Good", "Strong", "Very Strong"];
    const colors = ["#ff4d4d", "#ffa500", "#ffd700", "#7fff00", "#4caf50"];

    return (
      <div className="password-strength">
        <div
          className="strength-bar"
          style={{
            width: `${(strength / 5) * 100}%`,
            backgroundColor: colors[strength - 1],
          }}
        ></div>
        <span className="strength-label">
          {strengthLabels[strength - 1] || "Too Weak"}
        </span>
      </div>
    );
  };

  const handleRegister = async (e) => {
    e.preventDefault();

    try {
      const response = await axios.post('http://localhost:8000/api/register', {
        ime: username,
        email: email,
        lozinka: password,
        lozinka_confirmation: confirmPassword
      });
      console.log(response.data);
      alert('Registration successful');
      
      // Preusmeravamo korisnika na login stranicu nakon uspešne registracije
      navigate('/login');
    } catch (error) {
      console.error('Error registering user:', error);
      alert('Registration failed');
    }
  };

  // Definisanje prevoda
  const translations = {
    en: {
      registerPage: "Register Page",
      username: "Username",
      email: "Email",
      password: "Password",
      confirmPassword: "Confirm Password",
      register: "Register",
      alreadyHaveAccount: "Already have an account?",
      loginHere: "Login here",
      passwordStrength: "Password Strength",
      passwordsDoNotMatch: "Passwords do not match"
    },
    sr: {
      registerPage: "Stranica za registraciju",
      username: "Korisničko ime",
      email: "Email",
      password: "Lozinka",
      confirmPassword: "Potvrdite lozinku",
      register: "Registrujte se",
      alreadyHaveAccount: "Već imate nalog?",
      loginHere: "Prijavite se ovde",
      passwordStrength: "Snaga lozinke",
      passwordsDoNotMatch: "Lozinke se ne poklapaju"
    }
  };

  return (
    <div className="login-container">
      <h1>{translations[language].registerPage}</h1>
      <form className="login-form" onSubmit={handleRegister}>
        <div className="input-group">
          <label>{translations[language].username}:</label>
          <input
            type="text"
            name="username"
            value={username}
            onChange={(e) => setUsername(e.target.value)}
            className="text-input"
            required
          />
        </div>
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
              value={password}
              onChange={handlePasswordChange}
              className="password-input"
              required
            />
            <span className="toggle-password" onClick={toggleShowPassword}>
              {showPassword ? "🙈" : "👁️"}
            </span>
          </div>
          {passwordError && (
            <small className="error-message">{passwordError}</small>
          )}
          {renderStrengthBar()}
        </div>
        <div className="input-group password-field">
          <label>{translations[language].confirmPassword}:</label>
          <div className="password-input-wrapper">
            <input
              type={showConfirmPassword ? "text" : "password"}
              value={confirmPassword}
              onChange={handleConfirmPasswordChange}
              className="password-input"
              required
            />
            <span className="toggle-password" onClick={toggleShowConfirmPassword}>
              {showConfirmPassword ? "🙈" : "👁️"}
            </span>
          </div>
          {matchError && <small className="error-message">{translations[language].passwordsDoNotMatch}</small>}
        </div>
        <button
          type="submit"
          className="login-button"
          disabled={passwordError || matchError}
        >
          {translations[language].register}
        </button>
      </form>

      <div className="login-link">
        <p>{translations[language].alreadyHaveAccount} <Link to="/login">{translations[language].loginHere}</Link></p>
      </div>
    </div>
  );
};

export default Register;
