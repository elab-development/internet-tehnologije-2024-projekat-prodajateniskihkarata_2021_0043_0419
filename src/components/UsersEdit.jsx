import React, { useState, useEffect } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import './UsersEdit.css';

const UsersEdit = () => {
    const { id } = useParams();  // Dobijanje ID-a korisnika iz URL-a
    const [userData, setUserData] = useState({
        ime: '',
        email: '',
        uloga: '',
        datum_registracije: '',  // Dodajemo datum registracije
        lozinka: ''  // Lozinka je opcionalna
    });
    const [loading, setLoading] = useState(true);
    const navigate = useNavigate();

    const roles = ['guest', 'auth_user', 'admin'];  // Lista mogućih uloga

    useEffect(() => {
        const fetchUserData = async () => {
            try {
                const token = localStorage.getItem('token');
                if (!token) {
                    console.error("Token nije pronađen!");
                    return;
                }

                const response = await fetch(`http://localhost:8000/api/korisnici/${id}`, {
                    headers: { Authorization: `Bearer ${token}` }
                });

                if (!response.ok) {
                    throw new Error('Greška pri učitavanju podataka za korisnika');
                }

                const data = await response.json();
                setUserData({
                    ime: data.ime,
                    email: data.email,
                    uloga: data.uloga,
                    datum_registracije: data.datum_registracije,  // Datum registracije
                    lozinka: ''  // Lozinka resetovana, opcionalno za unos
                });
            } catch (error) {
                console.error('Greška pri učitavanju korisničkih podataka:', error);
            } finally {
                setLoading(false);
            }
        };

        fetchUserData();
    }, [id]);

    const handleChange = (e) => {
        const { name, value } = e.target;
        setUserData({ ...userData, [name]: value });
    };

    const handleUpdate = async (e) => {
        e.preventDefault();
        const token = localStorage.getItem('token');
        try {
            const updatedData = {
                ime: userData.ime,
                email: userData.email,
                uloga: userData.uloga,
                lozinka: userData.lozinka || null,  // Lozinka je opcionalna
            };

            const response = await fetch(`http://localhost:8000/api/korisnici/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify(updatedData)
            });

            if (!response.ok) {
                throw new Error('Greška pri ažuriranju korisnika');
            }

            navigate('/users');  // Preusmeravanje na listu korisnika
        } catch (error) {
            console.error('Greška pri ažuriranju korisnika:', error);
        }
    };

    if (loading) {
        return <p>Učitavanje podataka za korisnika...</p>;
    }

    return (
        <div className="edit-user-container">
            <h2>Izmena korisnika</h2>
            <form onSubmit={handleUpdate}>
                <div className="form-group">
                    <label>Ime</label>
                    <input
                        type="text"
                        name="ime"
                        value={userData.ime}
                        onChange={handleChange}
                    />
                </div>
                <div className="form-group">
                    <label>Email</label>
                    <input
                        type="email"
                        name="email"
                        value={userData.email}
                        onChange={handleChange}
                    />
                </div>
                <div className="form-group">
                    <label>Uloga</label>
                    <select
                        name="uloga"
                        value={userData.uloga}
                        onChange={handleChange}
                    >
                        {roles.map((role) => (
                            <option key={role} value={role}>
                                {role.charAt(0).toUpperCase() + role.slice(1)}
                            </option>
                        ))}
                    </select>
                </div>
                <div className="form-group">
                    <label>Datum registracije</label>
                    <input
                        type="text"
                        name="datum_registracije"
                        value={userData.datum_registracije}
                        readOnly
                    />
                </div>
                <div className="form-group">
                    <label>Lozinka (opcionalno)</label>
                    <input
                        type="password"
                        name="lozinka"
                        value={userData.lozinka}
                        onChange={handleChange}
                    />
                </div>
                <button type="submit">Ažuriraj</button>
            </form>
        </div>
    );
};

export default UsersEdit;










// import React, { useState, useEffect } from 'react';
// import { useParams, useNavigate } from 'react-router-dom';
// //import './UsersEdit.css';

// const UsersEdit = () => {
//     const { id } = useParams();  // Dobijanje ID-a korisnika iz URL-a
//     const [userData, setUserData] = useState({
//         ime: '',
//         email: '',
//         uloga: ''
//     });
//     const [loading, setLoading] = useState(true);
//     const navigate = useNavigate();

//     useEffect(() => {
//         const fetchUserData = async () => {
//             try {
//                 const token = localStorage.getItem('token');
//                 if (!token) {
//                     console.error("Token nije pronađen!");
//                     return;
//                 }

//                 const response = await fetch(`http://localhost:8000/api/korisnici/${id}`, {
//                     headers: { Authorization: `Bearer ${token}` }
//                 });

//                 if (!response.ok) {
//                     throw new Error('Greška pri učitavanju podataka za korisnika');
//                 }

//                 const data = await response.json();
//                 setUserData({
//                     ime: data.ime,
//                     email: data.email,
//                     uloga: data.uloga
//                 });
//             } catch (error) {
//                 console.error('Greška pri učitavanju korisničkih podataka:', error);
//             } finally {
//                 setLoading(false);
//             }
//         };

//         fetchUserData();
//     }, [id]);

//     const handleChange = (e) => {
//         const { name, value } = e.target;
//         setUserData({ ...userData, [name]: value });
//     };

//     const handleUpdate = async (e) => {
//         e.preventDefault();
//         const token = localStorage.getItem('token');
//         try {
//             const response = await fetch(`http://localhost:8000/api/korisnici/${id}`, {
//                 method: 'PUT',
//                 headers: {
//                     'Content-Type': 'application/json',
//                     'Authorization': `Bearer ${token}`
//                 },
//                 body: JSON.stringify(userData)
//             });

//             if (!response.ok) {
//                 throw new Error('Greška pri ažuriranju korisnika');
//             }

//             navigate('/users');  // Nakon uspešne izmene, preusmeri nazad na listu korisnika
//         } catch (error) {
//             console.error('Greška pri ažuriranju korisnika:', error);
//         }
//     };

//     if (loading) {
//         return <p>Učitavanje podataka za korisnika...</p>;
//     }

//     return (
//         <div className="edit-user-container">
//             <h2>Izmena korisnika</h2>
//             <form onSubmit={handleUpdate}>
//                 <div className="form-group">
//                     <label>Ime</label>
//                     <input
//                         type="text"
//                         name="ime"
//                         value={userData.ime}
//                         onChange={handleChange}
//                         disabled
//                     />
//                 </div>
//                 <div className="form-group">
//                     <label>Email</label>
//                     <input
//                         type="email"
//                         name="email"
//                         value={userData.email}
//                         onChange={handleChange}
//                     />
//                 </div>
//                 <div className="form-group">
//                     <label>Uloga</label>
//                     <input
//                         type="text"
//                         name="uloga"
//                         value={userData.uloga}
//                         onChange={handleChange}
//                     />
//                 </div>
//                 <button type="submit">Ažuriraj</button>
//             </form>
//         </div>
//     );
// };

// export default UsersEdit;
