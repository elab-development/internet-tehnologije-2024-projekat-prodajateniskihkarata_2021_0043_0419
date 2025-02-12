import React, { useEffect, useState, useContext } from 'react';
import { UserContext } from '../contexts/UserContext';
import { useNavigate } from 'react-router-dom';

const AdminUsers = () => {
    const { user } = useContext(UserContext);
    const [users, setUsers] = useState([]);
    const [loading, setLoading] = useState(true);
    const [newUser, setNewUser] = useState({ ime: '', email: '', lozinka: '', uloga: 'auth_user' });
    const navigate = useNavigate();

    useEffect(() => {
        if (!user || user.uloga !== 'admin') {
            navigate('/');
            return;
        }

        const fetchUsers = async () => {
            try {
                const token = localStorage.getItem('token');
                const response = await fetch('http://localhost:8000/api/korisnici', {
                    headers: { Authorization: `Bearer ${token}` }
                });

                if (!response.ok) throw new Error('Failed to fetch users');
                const data = await response.json();
                setUsers(data);
            } catch (error) {
                console.error('Error fetching users:', error);
            } finally {
                setLoading(false);
            }
        };

        fetchUsers();
    }, [user, navigate]);

    const handleCreateUser = async () => {
        try {
            const token = localStorage.getItem('token');
            await fetch('http://localhost:8000/api/korisnici', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`
                },
                body: JSON.stringify(newUser)
            });
            setNewUser({ ime: '', email: '', lozinka: '', uloga: 'auth_user' });
            setUsers([...users, newUser]); 
        } catch (error) {
            console.error("Error creating user:", error);
        }
    };

    const handleUpdateUser = async (id, updatedUser) => {
        try {
            const token = localStorage.getItem('token');
            await fetch(`http://localhost:8000/api/korisnici/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    Authorization: `Bearer ${token}`
                },
                body: JSON.stringify(updatedUser)
            });
            setUsers(users.map(user => user.id === id ? updatedUser : user));
        } catch (error) {
            console.error("Error updating user:", error);
        }
    };

    const handleDeleteUser = async (id) => {
        try {
            const token = localStorage.getItem('token');
            await fetch(`http://localhost:8000/api/korisnici/${id}`, {
                method: 'DELETE',
                headers: { Authorization: `Bearer ${token}` }
            });
            setUsers(users.filter(user => user.id !== id));
        } catch (error) {
            console.error("Error deleting user:", error);
        }
    };

    if (loading) return <p>Loading users...</p>;

    return (
        <div>
            <h2>Upravljanje korisnicima</h2>
            <div>
                <input type="text" placeholder="Ime" value={newUser.ime} onChange={(e) => setNewUser({ ...newUser, ime: e.target.value })} />
                <input type="email" placeholder="Email" value={newUser.email} onChange={(e) => setNewUser({ ...newUser, email: e.target.value })} />
                <input type="password" placeholder="Lozinka" value={newUser.lozinka} onChange={(e) => setNewUser({ ...newUser, lozinka: e.target.value })} />
                <button onClick={handleCreateUser}>Dodaj korisnika</button>
            </div>
            <ul>
                {users.map(korisnik => (
                    <li key={korisnik.id}>
                        {korisnik.ime} ({korisnik.email}) - {korisnik.uloga}
                        <button onClick={() => handleUpdateUser(korisnik.id, { ...korisnik, ime: korisnik.ime + " (izmenjen)" })}>Izmeni</button>
                        <button onClick={() => handleDeleteUser(korisnik.id)}>Obriši</button>
                    </li>
                ))}
            </ul>
        </div>
    );
};

export default AdminUsers;
