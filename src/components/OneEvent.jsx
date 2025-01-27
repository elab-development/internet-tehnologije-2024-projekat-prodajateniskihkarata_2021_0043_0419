import React, { useState } from "react";
import axios from "axios";
import "./OneEvent.css";

const OneEvent = ({ dogadjaj }) => {
  const [showModal, setShowModal] = useState(false);
  const [matchDetails, setMatchDetails] = useState(null);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  const handleOpenModal = async () => {
    setShowModal(true);
    document.body.classList.add("modal-open"); // Dodajemo klasu za onemogućavanje pozadine
    setLoading(true);
    try {
      const response = await axios.get(`http://localhost:8000/api/dogadjaji/${dogadjaj.id}`);
      setMatchDetails(response.data);
      setLoading(false);
    } catch (err) {
      setError("Ne možemo da pronađemo detalje o ovom meču.");
      console.error(err);
      setLoading(false);
    }
  };

  const handleCloseModal = () => {
    setShowModal(false);
    document.body.classList.remove("modal-open"); // Uklanjamo klasu kada se modal zatvori
  };

  const handleOverlayClick = (e) => {
    if (e.target.className === "modal-overlay") {
      handleCloseModal();
    }
  };

  return (
    <div className="card">
      <div className="card-header">Featured</div>
      <div className="card-body">
        <h5 className="card-title">{dogadjaj.ime_dogadjaja}</h5>
        <p className="card-text">{dogadjaj.lokacija}</p>
        <p className="card-text">{dogadjaj.opis}</p>
        <p className="card-text">{dogadjaj.status}</p>
        <button onClick={handleOpenModal} className="btn btn-primary">
          Details
        </button>
      </div>
      <div className="card-footer text-muted">{dogadjaj.datum_registracije}</div>

      {showModal && (
        <div className="modal-overlay" onClick={handleOverlayClick}>
          <div className="modal-content">
            {loading ? (
              <p>Učitavanje detalja o meču...</p>
            ) : error ? (
              <p>{error}</p>
            ) : (
              <>
                <h2>Detalji o meču</h2>
                <p><strong>Naziv:</strong> {matchDetails.ime_dogadjaja}</p>
                <p><strong>Lokacija:</strong> {matchDetails.lokacija}</p>
                <p><strong>Datum:</strong> {matchDetails.datum}</p>
                <p><strong>Status:</strong> {matchDetails.status}</p>
                <p><strong>Opis:</strong> {matchDetails.opis}</p>
                <button onClick={handleCloseModal} className="btn btn-secondary">
                  Zatvori
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