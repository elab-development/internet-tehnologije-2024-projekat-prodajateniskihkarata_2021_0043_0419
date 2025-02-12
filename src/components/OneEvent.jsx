import React, { useState, useEffect } from "react";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import { useLanguage } from "../contexts/LanguageContext";
import "./OneEvent.css";

const OneEvent = ({ dogadjaj, isAdmin }) => {
  const { language } = useLanguage(); // Koristimo language iz context-a
  const navigate = useNavigate();
  const [showModal, setShowModal] = useState(false);
  const [matchDetails, setMatchDetails] = useState(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);
  const [translations, setTranslations] = useState({});

  useEffect(() => {
    // Prevođenje teksta zavisi od jezika
    const translatedText = {
      sr: {
        header: "Istaknuto",
        detailsButton: "Detalji",
        editButton: "Izmeni",
        deleteButton: "Obriši",
        loading: "Učitavanje detalja o meču...",
        matchDetailsHeader: "Detalji o meču",
        name: "Naziv",
        location: "Lokacija",
        date: "Datum",
        status: "Status",
        description: "Opis",
        closeButton: "Zatvori",
        confirmDelete: "Da li ste sigurni da želite da obrišete ovaj meč?",
        notLoggedIn: "Niste ulogovani!",
        successDelete: "Meč uspešno obrisan!",
        errorDelete: "Došlo je do greške pri brisanju meča.",
      },
      en: {
        header: "Featured",
        detailsButton: "Details",
        editButton: "Edit",
        deleteButton: "Delete",
        loading: "Loading match details...",
        matchDetailsHeader: "Match Details",
        name: "Name",
        location: "Location",
        date: "Date",
        status: "Status",
        description: "Description",
        closeButton: "Close",
        confirmDelete: "Are you sure you want to delete this match?",
        notLoggedIn: "You are not logged in!",
        successDelete: "Match successfully deleted!",
        errorDelete: "Error occurred while deleting the match.",
      }
    };
    setTranslations(translatedText[language]);
  }, [language]);

  const handleOpenModal = async () => {
    if (showModal) return; // Ako je već otvoren, ne otvaraj ponovo
    setShowModal(true);
    document.body.classList.add("modal-open");
    setLoading(true);
  
    try {
      const response = await axios.get(`http://localhost:8000/api/dogadjaji/${dogadjaj.id}`);
      setMatchDetails(response.data);
    } catch (err) {
      setError(language === "sr" ? "Ne možemo da pronađemo detalje o ovom meču." : "We can't find match details.");
      console.error(err);
    } finally {
      setLoading(false);
    }
  };
  
  
  
  const handleCloseModal = (e) => {
    e.stopPropagation();
    setShowModal(false);
    document.body.classList.remove("modal-open");
  };
  
  
  

  const handleDelete = async () => {
    if (window.confirm(translations.confirmDelete)) {
      try {
        const token = localStorage.getItem("token");
        if (!token) {
          alert(translations.notLoggedIn);
          return;
        }

        await axios.delete(`http://localhost:8000/api/dogadjaji/${dogadjaj.id}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        alert(translations.successDelete);
        window.location.reload();
      } catch (err) {
        console.error("Greška prilikom brisanja:", err);
        alert(translations.errorDelete);
      }
    }
  };

  const handleEdit = () => {
    navigate(`/matches/edit/${dogadjaj.id}`);
  };

  return (
    <div className="card">
      <div className="card-header">{translations.header}</div>
      <div className="card-body">
        <h5 className="card-title">{dogadjaj.ime_dogadjaja}</h5>
        <p className="card-text">{dogadjaj.lokacija}</p>
        <p className="card-text">{dogadjaj.opis}</p>
        <p className="card-text">{dogadjaj.status}</p>

        <button onClick={handleOpenModal} className="btn btn-primary">
          {translations.detailsButton}
        </button>

        {isAdmin && (
          <>
            <button className="btn btn-warning ms-2" onClick={handleEdit}>
              {translations.editButton}
            </button>
            <button className="btn btn-danger ms-2" onClick={handleDelete}>
              {translations.deleteButton}
            </button>
          </>
        )}
      </div>
      <div className="card-footer text-muted">{dogadjaj.datum_registracije}</div>

      {showModal && (
  <div className="modal-overlay">
    <div className="modal-content">
      {loading ? (
        <p>{translations.loading}</p>
      ) : error ? (
        <p>{error}</p>
      ) : (
        <>
          <h2>{translations.matchDetailsHeader}</h2>
          <p><strong>{translations.name}:</strong> {matchDetails.ime_dogadjaja}</p>
          <p><strong>{translations.location}:</strong> {matchDetails.lokacija}</p>
          <p><strong>{translations.date}:</strong> {matchDetails.datum_registracije}</p>
          <p><strong>{translations.status}:</strong> {matchDetails.status}</p>
          <p><strong>{translations.description}:</strong> {matchDetails.opis}</p>
          <button onClick={handleCloseModal} className="btn btn-secondary">
            {translations.closeButton}
          </button>
        </>
      )}
    </div>
  </div>
)}



    </div>
  );
};

export default OneEvent;







// import React, { useState } from "react";
// import axios from "axios";
// import "./OneEvent.css";

// const OneEvent = ({ dogadjaj, user }) => {
//   const [showModal, setShowModal] = useState(false);
//   const [matchDetails, setMatchDetails] = useState(null);
//   const [loading, setLoading] = useState(false);
//   const [error, setError] = useState(null);
//   const [showEditModal, setShowEditModal] = useState(false);
//   const [editedEvent, setEditedEvent] = useState({
//     ime_dogadjaja: "",
//     lokacija: "",
//     datum: "",
//     status: "",
//     opis: "",
//   });

//   // Proverite da li je user objekat definisan i da li ima 'uloga'
//   console.log("User:", user);

//   const handleOpenModal = async () => {
//     setShowModal(true);
//     document.body.classList.add("modal-open");
//     setLoading(true);
//     try {
//       const response = await axios.get(`http://localhost:8000/api/dogadjaji/${dogadjaj.id}`);
//       setMatchDetails(response.data);
//       setLoading(false);
//     } catch (err) {
//       setError("Ne možemo da pronađemo detalje o ovom meču.");
//       console.error(err);
//       setLoading(false);
//     }
//   };

//   const handleCloseModal = () => {
//     setShowModal(false);
//     document.body.classList.remove("modal-open");
//   };

//   const handleOverlayClick = (e) => {
//     if (e.target.className === "modal-overlay") {
//       handleCloseModal();
//     }
//   };

//   const handleDelete = async () => {
//     try {
//       await axios.delete(`http://localhost:8000/api/dogadjaji/${dogadjaj.id}`);
//       alert("Događaj je obrisan!");
//     } catch (err) {
//       console.error("Greška pri brisanju događaja", err);
//     }
//   };

//   const handleEdit = () => {
//     setEditedEvent({
//       ime_dogadjaja: dogadjaj.ime_dogadjaja,
//       lokacija: dogadjaj.lokacija,
//       datum: dogadjaj.datum,
//       status: dogadjaj.status,
//       opis: dogadjaj.opis,
//     });
//     setShowEditModal(true);
//   };

//   const handleEditSubmit = async (e) => {
//     e.preventDefault();
//     try {
//       await axios.put(`http://localhost:8000/api/dogadjaji/${dogadjaj.id}`, editedEvent);
//       alert("Događaj je ažuriran!");
//       setShowEditModal(false);
//     } catch (err) {
//       console.error("Greška pri ažuriranju događaja", err);
//     }
//   };

//   return (
//     <div className="card">
//       <div className="card-header">Featured</div>
//       <div className="card-body">
//         <h5 className="card-title">{dogadjaj.ime_dogadjaja}</h5>
//         <p className="card-text">{dogadjaj.lokacija}</p>
//         <p className="card-text">{dogadjaj.opis}</p>
//         <p className="card-text">{dogadjaj.status}</p>
//         <button onClick={handleOpenModal} className="btn btn-primary">
//           Details
//         </button>

//         {/* Provera da li user ima ulogu admin */}
//         {user && user.uloga === "admin" ? (
//           <div className="admin-buttons">
//             <button onClick={handleEdit} className="btn btn-warning mt-2">Izmeni</button>
//             <button onClick={handleDelete} className="btn btn-danger mt-2">Obriši</button>
//           </div>
//         ) : (
//           <></> // Ako nije admin, ništa se ne prikazuje
//         )}
//       </div>
//       <div className="card-footer text-muted">{dogadjaj.datum_registracije}</div>

//       {/* Modal za detalje događaja */}
//       {showModal && (
//         <div className="modal-overlay" onClick={handleOverlayClick}>
//           <div className="modal-content">
//             {loading ? (
//               <p>Učitavanje detalja o meču...</p>
//             ) : error ? (
//               <p>{error}</p>
//             ) : (
//               <>
//                 <h2>Detalji o meču</h2>
//                 <p><strong>Naziv:</strong> {matchDetails.ime_dogadjaja}</p>
//                 <p><strong>Lokacija:</strong> {matchDetails.lokacija}</p>
//                 <p><strong>Datum:</strong> {matchDetails.datum}</p>
//                 <p><strong>Status:</strong> {matchDetails.status}</p>
//                 <p><strong>Opis:</strong> {matchDetails.opis}</p>
//                 <button onClick={handleCloseModal} className="btn btn-secondary">
//                   Zatvori
//                 </button>
//               </>
//             )}
//           </div>
//         </div>
//       )}

//       {/* Modal za editovanje događaja */}
//       {showEditModal && (
//         <div className="modal-overlay" onClick={handleOverlayClick}>
//           <div className="modal-content">
//             <h2>Izmeni Događaj</h2>
//             <form onSubmit={handleEditSubmit}>
//               <div className="form-group">
//                 <label htmlFor="ime_dogadjaja">Naziv</label>
//                 <input
//                   type="text"
//                   id="ime_dogadjaja"
//                   value={editedEvent.ime_dogadjaja}
//                   onChange={(e) =>
//                     setEditedEvent({ ...editedEvent, ime_dogadjaja: e.target.value })
//                   }
//                   className="form-control"
//                 />
//               </div>
//               <div className="form-group">
//                 <label htmlFor="lokacija">Lokacija</label>
//                 <input
//                   type="text"
//                   id="lokacija"
//                   value={editedEvent.lokacija}
//                   onChange={(e) =>
//                     setEditedEvent({ ...editedEvent, lokacija: e.target.value })
//                   }
//                   className="form-control"
//                 />
//               </div>
//               <div className="form-group">
//                 <label htmlFor="datum">Datum</label>
//                 <input
//                   type="text"
//                   id="datum"
//                   value={editedEvent.datum}
//                   onChange={(e) =>
//                     setEditedEvent({ ...editedEvent, datum: e.target.value })
//                   }
//                   className="form-control"
//                 />
//               </div>
//               <div className="form-group">
//                 <label htmlFor="status">Status</label>
//                 <input
//                   type="text"
//                   id="status"
//                   value={editedEvent.status}
//                   onChange={(e) =>
//                     setEditedEvent({ ...editedEvent, status: e.target.value })
//                   }
//                   className="form-control"
//                 />
//               </div>
//               <div className="form-group">
//                 <label htmlFor="opis">Opis</label>
//                 <textarea
//                   id="opis"
//                   value={editedEvent.opis}
//                   onChange={(e) =>
//                     setEditedEvent({ ...editedEvent, opis: e.target.value })
//                   }
//                   className="form-control"
//                 />
//               </div>
//               <button type="submit" className="btn btn-primary mt-3">
//                 Ažuriraj
//               </button>
//               <button
//                 onClick={() => setShowEditModal(false)}
//                 className="btn btn-secondary mt-3"
//               >
//                 Zatvori
//               </button>
//             </form>
//           </div>
//         </div>
//       )}
//     </div>
//   );
// };

// export default OneEvent;






















 //////////// BARIJANTA KODA KADA SE OTVARAJU DETALJI NA NOVOJ STR ///////////////

// import React from 'react';
// import { Link } from 'react-router-dom'; // Dodato za navigaciju na stranicu sa detaljima

// const OneEvent = ({ dogadjaj }) => {
//   return (
//     <div className="card">
//       <div className="card-header">
//         Featured
//       </div>
//       <div className="card-body">
//         <h5 className="card-title">{dogadjaj.ime_dogadjaja}</h5>
//         <p className="card-text"><strong>Lokacija:</strong> {dogadjaj.lokacija}</p>
//         <p className="card-text"><strong>Opis:</strong> {dogadjaj.opis}</p>
//         <p className="card-text"><strong>Status:</strong> {dogadjaj.status}</p>
//         <Link to={`/matches/${dogadjaj.id}`} className="btn btn-primary">
//           Detalji
//         </Link>
//       </div>
//       <div className="card-footer text-muted">
//         {dogadjaj.datum_registracije}
//       </div>
//     </div>
//   );
// };

// export default OneEvent;


/*

import React from 'react';

const OneEvent = ({ dogadjaj }) => {
  return (
    <div className="card mb-3 shadow-sm">
      <div className="card-header bg-primary text-white">
        {dogadjaj.ime_dogadjaja}
      </div>
      <div className="card-body">
        <p className="card-text">
          <strong>Lokacija:</strong> {dogadjaj.lokacija}
        </p>
        <p className="card-text">
          <strong>Opis:</strong> {dogadjaj.opis}
        </p>
        <p className={`card-text ${dogadjaj.status === 'zakazan' ? 'text-success' : dogadjaj.status === 'otkazan' ? 'text-danger' : 'text-secondary'}`}>
          <strong>Status:</strong> {dogadjaj.status}
        </p>
        <a href="#" className="btn btn-outline-primary btn-sm">
          Detalji
        </a>
      </div>
      <div className="card-footer text-muted">
        <small>Datum registracije: {new Date(dogadjaj.datum_registracije).toLocaleDateString()}</small>
      </div>
    </div>
  );
};

export default OneEvent;



*/ 