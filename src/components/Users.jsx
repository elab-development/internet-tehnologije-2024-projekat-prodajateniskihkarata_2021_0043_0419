import React, { useEffect, useState, useContext } from 'react';
import { UserContext } from '../contexts/UserContext';
import { useNavigate } from 'react-router-dom';
import './Users.css';

const Users = () => {
    const { user } = useContext(UserContext);
    const [users, setUsers] = useState([]);
    const [filteredUsers, setFilteredUsers] = useState([]);
    const [loading, setLoading] = useState(true);
    const [search, setSearch] = useState({ ime: '', email: '', uloga: '', id: '', datum: '' });
    const navigate = useNavigate();

    useEffect(() => {
        if (!user || user.uloga !== 'admin') {
            navigate('/');
            return;
        }

        const fetchUsers = async () => {
            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    console.error("Token nije pronađen!");
                    return;
                }

                const response = await fetch('http://localhost:8000/api/korisnici', {
                    headers: { Authorization: `Bearer ${token}` }
                });

                if (!response.ok) {
                    throw new Error(`Failed to fetch users: ${response.status}`);
                }

                const data = await response.json();
                setUsers(data);
                setFilteredUsers(data);
            } catch (error) {
                console.error('Greška pri učitavanju korisnika:', error);
            } finally {
                setLoading(false);
            }
        };

        fetchUsers();
    }, [user, navigate]);

    const handleDelete = async (id) => {
        const confirmDelete = window.confirm("Da li ste sigurni da želite da obrišete korisnika?");
        if (!confirmDelete) return;

        try {
            const token = localStorage.getItem('token');
            const response = await fetch(`http://localhost:8000/api/korisnici/${id}`, {
                method: 'DELETE',
                headers: { Authorization: `Bearer ${token}` }
            });

            if (!response.ok) {
                throw new Error('Greška pri brisanju korisnika');
            }

            setUsers(users.filter(korisnik => korisnik.id !== id));
            setFilteredUsers(filteredUsers.filter(korisnik => korisnik.id !== id));
        } catch (error) {
            console.error(error);
        }
    };

    const handleSearch = (e) => {
        const { name, value } = e.target;
        setSearch({ ...search, [name]: value });
        filterUsers({ ...search, [name]: value });
    };

    const filterUsers = (searchParams) => {
        const filtered = users.filter(korisnik =>
            korisnik.ime.toLowerCase().includes(searchParams.ime.toLowerCase()) &&
            korisnik.email.toLowerCase().includes(searchParams.email.toLowerCase()) &&
            korisnik.uloga.toLowerCase().includes(searchParams.uloga.toLowerCase()) &&
            (korisnik.id.toString().includes(searchParams.id) || searchParams.id === '') &&
            (new Date(korisnik.datum_registracije).toLocaleDateString().includes(searchParams.datum) || searchParams.datum === '')
        );
        setFilteredUsers(filtered);
    };

    if (loading) {
        return <p>Loading users...</p>;
    }

    return (
        <div className="users-container">
            <h2>Lista korisnika</h2>
            <div className="search-container">
                <input type="text" name="id" placeholder="Pretraga po ID-u" value={search.id} onChange={handleSearch} />
                <input type="text" name="ime" placeholder="Pretraga po imenu" value={search.ime} onChange={handleSearch} />
                <input type="text" name="email" placeholder="Pretraga po emailu" value={search.email} onChange={handleSearch} />
                <input type="text" name="uloga" placeholder="Pretraga po ulozi" value={search.uloga} onChange={handleSearch} />
                <input type="text" name="datum" placeholder="Pretraga po datumu" value={search.datum} onChange={handleSearch} />
            </div>
            <table className="users-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ime</th>
                        <th>Email</th>
                        <th>Uloga</th>
                        <th>Datum registracije</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    {filteredUsers.length > 0 ? (
                        filteredUsers.map((korisnik) => (
                            <tr key={korisnik.id}>
                                <td>{korisnik.id}</td>
                                <td>{korisnik.ime}</td>
                                <td>{korisnik.email}</td>
                                <td>{korisnik.uloga}</td>
                                <td>{new Date(korisnik.datum_registracije).toLocaleString()}</td>
                                <td>
                                    <button className="edit-btn" onClick={() => navigate(`/users/edit/${korisnik.id}`)}>✏️</button>
                                    <button className="delete-btn" onClick={() => handleDelete(korisnik.id)}>🗑️</button>
                                </td>
                            </tr>
                        ))
                    ) : (
                        <tr>
                            <td colSpan="6">Nema dostupnih korisnika.</td>
                        </tr>
                    )}
                </tbody>
            </table>
        </div>
    );
};

export default Users;





// import React, { useEffect, useState, useContext } from 'react';
// import { UserContext } from '../contexts/UserContext';
// import { useNavigate } from 'react-router-dom';

// const Users = () => {
//     const { user } = useContext(UserContext);
//     const [users, setUsers] = useState([]);
//     const [loading, setLoading] = useState(true);
//     const [searchTerm, setSearchTerm] = useState({
//         id: '',
//         ime: '',
//         email: '',
//         uloga: '',
//         datum_registracije: ''
//     });
//     const navigate = useNavigate();

//     useEffect(() => {
//         if (!user || user.uloga !== 'admin') {
//             navigate('/'); // Redirekcija ako korisnik nije admin
//             return;
//         }

//         const fetchUsers = async () => {
//             try {
//                 const token = localStorage.getItem('token');
//                 const response = await fetch('http://localhost:8000/api/korisnici', {
//                     headers: {
//                         Authorization: `Bearer ${token}`
//                     }
//                 });

//                 if (!response.ok) {
//                     throw new Error('Failed to fetch users');
//                 }

//                 const data = await response.json();
//                 setUsers(data);
//             } catch (error) {
//                 console.error('Error fetching users:', error);
//             } finally {
//                 setLoading(false);
//             }
//         };

//         fetchUsers();
//     }, [user, navigate]);

//     const handleDelete = async (id) => {
//         try {
//             const token = localStorage.getItem('token');
//             const response = await fetch(`http://localhost:8000/api/korisnici/${id}`, {
//                 method: 'DELETE',
//                 headers: {
//                     Authorization: `Bearer ${token}`
//                 }
//             });

//             if (!response.ok) {
//                 throw new Error('Failed to delete user');
//             }

//             setUsers(users.filter(user => user.id !== id));
//         } catch (error) {
//             console.error('Error deleting user:', error);
//         }
//     };

//     const handleEdit = (id) => {
//         navigate(`/edit-user/${id}`);
//     };

//     const handleSearchChange = (e) => {
//         setSearchTerm({ ...searchTerm, [e.target.name]: e.target.value });
//     };

//     const filteredUsers = users.filter(korisnik =>
//         korisnik.id.toString().includes(searchTerm.id) &&
//         korisnik.ime.toLowerCase().includes(searchTerm.ime.toLowerCase()) &&
//         korisnik.email.toLowerCase().includes(searchTerm.email.toLowerCase()) &&
//         korisnik.uloga.toLowerCase().includes(searchTerm.uloga.toLowerCase()) &&
//         korisnik.datum_registracije.toLowerCase().includes(searchTerm.datum_registracije.toLowerCase())
//     );

//     if (loading) {
//         return <p>Loading users...</p>;
//     }

//     return (
//         <div>
//             <h2>User List</h2>
//             <table>
//                 <thead>
//                     <tr>
//                         <th><input type="text" name="id" placeholder="Search ID" value={searchTerm.id} onChange={handleSearchChange} /></th>
//                         <th><input type="text" name="ime" placeholder="Search Name" value={searchTerm.ime} onChange={handleSearchChange} /></th>
//                         <th><input type="text" name="email" placeholder="Search Email" value={searchTerm.email} onChange={handleSearchChange} /></th>
//                         <th><input type="text" name="uloga" placeholder="Search Role" value={searchTerm.uloga} onChange={handleSearchChange} /></th>
//                         <th><input type="text" name="datum_registracije" placeholder="Search Date" value={searchTerm.datum_registracije} onChange={handleSearchChange} /></th>
//                         <th>Actions</th>
//                     </tr>
//                 </thead>
//                 <tbody>
//                     {filteredUsers.map((korisnik) => (
//                         <tr key={korisnik.id}>
//                             <td>{korisnik.id}</td>
//                             <td>{korisnik.ime}</td>
//                             <td>{korisnik.email}</td>
//                             <td>{korisnik.uloga}</td>
//                             <td>{new Date(korisnik.datum_registracije).toLocaleString()}</td>
//                             <td>
//                                 <button onClick={() => handleEdit(korisnik.id)}>Edit</button>
//                                 <button onClick={() => handleDelete(korisnik.id)}>Delete</button>
//                             </td>
//                         </tr>
//                     ))}
//                 </tbody>
//             </table>
//         </div>
//     );
// };

// export default Users;





// TOP IZGLED

// import React, { useEffect, useState, useContext } from 'react';
// import { UserContext } from '../contexts/UserContext';
// import { useNavigate } from 'react-router-dom';
// import './Users.css'; // Dodajemo CSS fajl

// const Users = () => {
//     const { user } = useContext(UserContext);
//     const [users, setUsers] = useState([]);
//     const [loading, setLoading] = useState(true);
//     const navigate = useNavigate();

//     useEffect(() => {
//         if (!user || user.uloga !== 'admin') {
//             navigate('/'); // Redirekcija ako korisnik nije admin
//             return;
//         }

//         const fetchUsers = async () => {
//             try {
//                 const token = localStorage.getItem('token');
//                 if (!token) {
//                     console.error("Token nije pronađen!");
//                     return;
//                 }

//                 const response = await fetch('http://localhost:8000/api/korisnici', {
//                     headers: {
//                         Authorization: `Bearer ${token}`
//                     }
//                 });

//                 if (!response.ok) {
//                     throw new Error(`Failed to fetch users: ${response.status}`);
//                 }

//                 const data = await response.json();
//                 console.log("Dobijeni korisnici:", data); // Provera u konzoli
//                 setUsers(data);
//             } catch (error) {
//                 console.error('Greška pri učitavanju korisnika:', error);
//             } finally {
//                 setLoading(false);
//             }
//         };

//         fetchUsers();
//     }, [user, navigate]);

//     const handleEdit = (id) => {
//         console.log("Ažuriraj korisnika sa ID:", id);
//         // Ovde će ići logika za ažuriranje
//     };

//     const handleDelete = async (id) => {
//         console.log("Brisanje korisnika sa ID:", id);
//         // Ovde će ići logika za brisanje
//     };

//     if (loading) {
//         return <p>Loading users...</p>;
//     }

//     return (
//         <div className="users-container">
//             <h2>Lista korisnika</h2>
//             <table className="users-table">
//                 <thead>
//                     <tr>
//                         <th>ID</th>
//                         <th>Ime</th>
//                         <th>Email</th>
//                         <th>Uloga</th>
//                         <th>Datum registracije</th>
//                         <th>Akcije</th>
//                     </tr>
//                 </thead>
//                 <tbody>
//                     {users.length > 0 ? (
//                         users.map((korisnik) => (
//                             <tr key={korisnik.id}>
//                                 <td>{korisnik.id}</td>
//                                 <td>{korisnik.ime}</td>
//                                 <td>{korisnik.email}</td>
//                                 <td>{korisnik.uloga}</td>
//                                 <td>{new Date(korisnik.datum_registracije).toLocaleString()}</td>
//                                 <td>
//                                     <button className="edit-btn" onClick={() => handleEdit(korisnik.id)}>✏️</button>
//                                     <button className="delete-btn" onClick={() => handleDelete(korisnik.id)}>🗑️</button>
//                                 </td>
//                             </tr>
//                         ))
//                     ) : (
//                         <tr>
//                             <td colSpan="6">Nema dostupnih korisnika.</td>
//                         </tr>
//                     )}
//                 </tbody>
//             </table>
//         </div>
//     );
// };

// export default Users;
















// import React, { useEffect, useState, useContext } from 'react';
// import { UserContext } from '../contexts/UserContext';
// import { useNavigate } from 'react-router-dom';

// const Users = () => {
//     const { user } = useContext(UserContext);
//     const [users, setUsers] = useState([]);
//     const [loading, setLoading] = useState(true);
//     const navigate = useNavigate();

//     useEffect(() => {
//         if (!user || user.uloga !== 'admin') {
//             navigate('/'); // Redirekcija ako korisnik nije admin
//             return;
//         }

//         const fetchUsers = async () => {
//             try {
//                 const token = localStorage.getItem('token');
//                 const response = await fetch('http://localhost:8000/api/korisnici', {
//                     headers: {
//                         Authorization: `Bearer ${token}`
//                     }
//                 });

//                 if (!response.ok) {
//                     throw new Error('Failed to fetch users');
//                 }

//                 const data = await response.json();
//                 setUsers(data);
//             } catch (error) {
//                 console.error('Error fetching users:', error);
//             } finally {
//                 setLoading(false);
//             }
//         };

//         fetchUsers();
//     }, [user, navigate]);

//     if (loading) {
//         return <p>Loading users...</p>;
//     }

//     return (
//         <div>
//             <h2>User List</h2>
//             <table>
//                 <thead>
//                     <tr>
//                         <th>ID</th>
//                         <th>Name</th>
//                         <th>Email</th>
//                         <th>Role</th>
//                         <th>Registered At</th>
//                     </tr>
//                 </thead>
//                 <tbody>
//                     {users.map((korisnik) => (
//                         <tr key={korisnik.id}>
//                             <td>{korisnik.id}</td>
//                             <td>{korisnik.ime}</td>
//                             <td>{korisnik.email}</td>
//                             <td>{korisnik.uloga}</td>
//                             <td>{new Date(korisnik.datum_registracije).toLocaleString()}</td>
//                         </tr>
//                     ))}
//                 </tbody>
//             </table>
//         </div>
//     );
// };

// export default Users;
