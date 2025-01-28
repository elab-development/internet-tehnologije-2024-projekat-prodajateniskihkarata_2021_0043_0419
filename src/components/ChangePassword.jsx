import React, { useState, useContext } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import { UserContext } from '../contexts/UserContext';

const ChangePassword = () => {
    const { user } = useContext(UserContext);
    const [currentPassword, setCurrentPassword] = useState('');
    const [newPassword, setNewPassword] = useState('');
    const [confirmNewPassword, setConfirmNewPassword] = useState('');
    const [showCurrentPassword, setShowCurrentPassword] = useState(false);
    const [showNewPassword, setShowNewPassword] = useState(false);
    const [showConfirmNewPassword, setShowConfirmNewPassword] = useState(false);
    const [error, setError] = useState('');
    const [success, setSuccess] = useState('');
    const navigate = useNavigate();

    const handleChangePassword = async (e) => {
        e.preventDefault();
        if (newPassword !== confirmNewPassword) {
            setError('Nova lozinka i potvrda nove lozinke se ne poklapaju.');
            return;
        }

        if (!user || !user.id) {
            setError('Korisnik nije prijavljen.');
            console.log('User or user ID is not defined:', user);
            return;
        }

        try {
            console.log(`Changing password for user ID: ${user.id}`);
            console.log(`Current Password: ${currentPassword}`);
            console.log(`New Password: ${newPassword}`);
            console.log(`Confirm New Password: ${confirmNewPassword}`);
            console.log(`Authorization Token: Bearer ${localStorage.getItem('token')}`);

            const response = await axios.post(`http://localhost:8000/api/korisnici/${user.id}/promena-lozinke`, {
                stara_lozinka: currentPassword,
                nova_lozinka: newPassword,
                nova_lozinka_confirmation: confirmNewPassword,
            }, {
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('token')}`
                }
            });

            setSuccess('Lozinka je uspešno promenjena.');
            setError('');
            setCurrentPassword('');
            setNewPassword('');
            setConfirmNewPassword('');
        } catch (error) {
            setError(error.response?.data?.error || 'Došlo je do greške prilikom promene lozinke.');
            setSuccess('');
            console.error('Error changing password:', error.response?.data);
        }
    };

    console.log('User data in ChangePassword:', user); // Dodajemo log

    return (
        <div className="change-password-container">
            <h1>Promena lozinke</h1>
            <form onSubmit={handleChangePassword}>
                <div className="input-group">
                    <label>Trenutna lozinka:</label>
                    <div className="password-input-wrapper">
                        <input
                            type={showCurrentPassword ? "text" : "password"}
                            value={currentPassword}
                            onChange={(e) => setCurrentPassword(e.target.value)}
                            required
                        />
                        <span className="toggle-password" onClick={() => setShowCurrentPassword(!showCurrentPassword)}>
                            {showCurrentPassword ? "🙈" : "👁️"}
                        </span>
                    </div>
                </div>
                <div className="input-group">
                    <label>Nova lozinka:</label>
                    <div className="password-input-wrapper">
                        <input
                            type={showNewPassword ? "text" : "password"}
                            value={newPassword}
                            onChange={(e) => setNewPassword(e.target.value)}
                            required
                        />
                        <span className="toggle-password" onClick={() => setShowNewPassword(!showNewPassword)}>
                            {showNewPassword ? "🙈" : "👁️"}
                        </span>
                    </div>
                </div>
                <div className="input-group">
                    <label>Potvrda nove lozinke:</label>
                    <div className="password-input-wrapper">
                        <input
                            type={showConfirmNewPassword ? "text" : "password"}
                            value={confirmNewPassword}
                            onChange={(e) => setConfirmNewPassword(e.target.value)}
                            required
                        />
                        <span className="toggle-password" onClick={() => setShowConfirmNewPassword(!showConfirmNewPassword)}>
                            {showConfirmNewPassword ? "🙈" : "👁️"}
                        </span>
                    </div>
                </div>
                {error && <p className="error-message">{error}</p>}
                {success && <p className="success-message">{success}</p>}
                <button type="submit">Promeni lozinku</button>
            </form>
        </div>
    );
};

export default ChangePassword;