import React, { useEffect, useState, useContext } from 'react';
import { UserContext } from '../contexts/UserContext';
import { useNavigate } from 'react-router-dom';
import './Payments.css';

const Payments = () => {
    const { user } = useContext(UserContext);
    const [payments, setPayments] = useState([]);
    const [filteredPayments, setFilteredPayments] = useState([]);
    const [loading, setLoading] = useState(true);
    const [search, setSearch] = useState({
        korisnik_id: '',
        iznos: '',
        datum_transakcije: '',
        status_transakcije: '',
        tip_placanja: ''
    });
    const navigate = useNavigate();

    useEffect(() => {
        console.log("Učitavanje plaćanja...");
        if (!user || user.uloga !== 'admin') {
            navigate('/');
            return;
        }

        const fetchPayments = async () => {
            try {
                const token = localStorage.getItem('token');
                console.log("Token:", token); // Logovanje tokena

                if (!token) {
                    console.error("Token nije pronađen!");
                    return;
                }

                const response = await fetch('http://localhost:8000/api/placanja', {
                    headers: { Authorization: `Bearer ${token}` }
                });

                if (!response.ok) {
                    throw new Error(`Failed to fetch payments: ${response.status}`);
                }

                const data = await response.json();
                console.log("Podaci o plaćanju: ", data); // Logovanje podataka koji dolaze sa servera
                setPayments(data);
                setFilteredPayments(data);
            } catch (error) {
                console.error('Greška pri učitavanju plaćanja:', error);
            } finally {
                setLoading(false);
            }
        };

        fetchPayments();
    }, [user, navigate]);

    const handleSearch = (e) => {
        const { name, value } = e.target;
        setSearch({ ...search, [name]: value });
        filterPayments({ ...search, [name]: value });
    };

    const filterPayments = (searchParams) => {
        const filtered = payments.filter(payment =>
            (payment.korisnik_id.toString().includes(searchParams.korisnik_id) || searchParams.korisnik_id === '') &&
            (payment.iznos.toString().includes(searchParams.iznos) || searchParams.iznos === '') &&
            (new Date(payment.datum_transakcije).toLocaleDateString().includes(searchParams.datum_transakcije) || searchParams.datum_transakcije === '') &&
            payment.status_transakcije.toLowerCase().includes(searchParams.status_transakcije.toLowerCase()) &&
            payment.tip_placanja.toLowerCase().includes(searchParams.tip_placanja.toLowerCase())
        );
        console.log("Filtered payments: ", filtered); // Logovanje filtriranih plaćanja
        setFilteredPayments(filtered);
    };

    if (loading) {
        return <p>Loading payments...</p>;
    }

    return (
        <div className="payments-container">
            <h2>Lista plaćanja</h2>
            {loading ? (
                <p>Loading payments...</p>
            ) : (
                <>
                    {payments.length > 0 ? (
                        <table className="payments-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Korisnik ID</th>
                                    <th>Iznos</th>
                                    <th>Datum transakcije</th>
                                    <th>Status</th>
                                    <th>Tip plaćanja</th>
                                </tr>
                            </thead>
                            <tbody>
                                {filteredPayments.map((payment) => (
                                    <tr key={payment.id}>
                                        <td>{payment.id}</td>
                                        <td>{payment.korisnik_id}</td>
                                        <td>{payment.iznos}</td>
                                        <td>{new Date(payment.datum_transakcije).toLocaleString()}</td>
                                        <td>{payment.status_transakcije}</td>
                                        <td>{payment.tip_placanja}</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    ) : (
                        <p>Nema plaćanja za prikazivanje.</p>
                    )}
                </>
            )}
        </div>
    );
};

export default Payments;




// import React, { useEffect, useState, useContext } from 'react';
// import { UserContext } from '../contexts/UserContext';
// import { useNavigate } from 'react-router-dom';
// import './Payments.css';

// const Payments = () => {
//     const { user } = useContext(UserContext);
//     const [payments, setPayments] = useState([]);
//     const [filteredPayments, setFilteredPayments] = useState([]);
//     const [loading, setLoading] = useState(true);
//     const [search, setSearch] = useState({
//         korisnik_id: '',
//         iznos: '',
//         datum_transakcije: '',
//         status_transakcije: '',
//         tip_placanja: ''
//     });
//     const navigate = useNavigate();

//     useEffect(() => {
//         console.log("Učitavanje plaćanja...");
//         if (!user || user.uloga !== 'admin') {
//             navigate('/');
//             return;
//         }

//         const fetchPayments = async () => {
//             try {
//                 const token = localStorage.getItem('token');
//                 console.log("Token:", token); // Logovanje tokena

//                 if (!token) {
//                     console.error("Token nije pronađen!");
//                     return;
//                 }

//                 const response = await fetch('http://localhost:8000/api/placanja', {
//                     headers: { Authorization: `Bearer ${token}` }
//                 });

//                 if (!response.ok) {
//                     throw new Error(`Failed to fetch payments: ${response.status}`);
//                 }

//                 const data = await response.json();
//                 console.log("Podaci o plaćanju: ", data); // Logovanje podataka koji dolaze sa servera
//                 setPayments(data);
//                 setFilteredPayments(data);
//             } catch (error) {
//                 console.error('Greška pri učitavanju plaćanja:', error);
//             } finally {
//                 setLoading(false);
//             }
//         };

//         fetchPayments();
//     }, [user, navigate]);

//     const handleDelete = async (id) => {
//         const confirmDelete = window.confirm("Da li ste sigurni da želite da obrišete plaćanje?");
//         if (!confirmDelete) return;

//         try {
//             const token = localStorage.getItem('token');
//             const response = await fetch(`http://localhost:8000/api/placanja/${id}`, {
//                 method: 'DELETE',
//                 headers: { Authorization: `Bearer ${token}` }
//             });

//             if (!response.ok) {
//                 throw new Error('Greška pri brisanju plaćanja');
//             }

//             setPayments(payments.filter(payment => payment.id !== id));
//             setFilteredPayments(filteredPayments.filter(payment => payment.id !== id));
//         } catch (error) {
//             console.error(error);
//         }
//     };

//     const handleSearch = (e) => {
//         const { name, value } = e.target;
//         setSearch({ ...search, [name]: value });
//         filterPayments({ ...search, [name]: value });
//     };

//     const filterPayments = (searchParams) => {
//         const filtered = payments.filter(payment =>
//             (payment.korisnik_id.toString().includes(searchParams.korisnik_id) || searchParams.korisnik_id === '') &&
//             (payment.iznos.toString().includes(searchParams.iznos) || searchParams.iznos === '') &&
//             (new Date(payment.datum_transakcije).toLocaleDateString().includes(searchParams.datum_transakcije) || searchParams.datum_transakcije === '') &&
//             payment.status_transakcije.toLowerCase().includes(searchParams.status_transakcije.toLowerCase()) &&
//             payment.tip_placanja.toLowerCase().includes(searchParams.tip_placanja.toLowerCase())
//         );
//         console.log("Filtered payments: ", filtered); // Logovanje filtriranih plaćanja
//         setFilteredPayments(filtered);
//     };

//     if (loading) {
//         return <p>Loading payments...</p>;
//     }

//     return (
//         <div className="payments-container">
//             <h2>Lista plaćanja</h2>
//             {loading ? (
//                 <p>Loading payments...</p>
//             ) : (
//                 <>
//                     {payments.length > 0 ? (
//                         <table className="payments-table">
//                             <thead>
//                                 <tr>
//                                     <th>ID</th>
//                                     <th>Korisnik ID</th>
//                                     <th>Iznos</th>
//                                     <th>Datum transakcije</th>
//                                     <th>Status</th>
//                                     <th>Tip plaćanja</th>
//                                     <th>Akcije</th>
//                                 </tr>
//                             </thead>
//                             <tbody>
//                                 {filteredPayments.map((payment) => (
//                                     <tr key={payment.id}>
//                                         <td>{payment.id}</td>
//                                         <td>{payment.korisnik_id}</td>
//                                         <td>{payment.iznos}</td>
//                                         <td>{new Date(payment.datum_transakcije).toLocaleString()}</td>
//                                         <td>{payment.status_transakcije}</td>
//                                         <td>{payment.tip_placanja}</td>
//                                         <td>
//                                             <button className="edit-btn" onClick={() => navigate(`/payments/edit/${payment.id}`)}>✏️</button>
//                                             <button className="delete-btn" onClick={() => handleDelete(payment.id)}>🗑️</button>
//                                         </td>
//                                     </tr>
//                                 ))}
//                             </tbody>
//                         </table>
//                     ) : (
//                         <p>Nema plaćanja za prikazivanje.</p>
//                     )}
//                 </>
//             )}
//         </div>
//     );
// };

// export default Payments;
