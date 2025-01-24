import React, { useState } from "react";

const OneEvent = ({ dogadjaj }) => {
  const [showModal, setShowModal] = useState(false);

  const handleOpenModal = () => {
    setShowModal(true);
  };

  const handleCloseModal = () => {
    setShowModal(false);
  };

  const handleOverlayClick = (e) => {
    // Zatvaranje modala samo ako je klik direktno na overlay
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
            <h2>Detalji o meču</h2>
            <p><strong>Naziv:</strong> {dogadjaj.ime_dogadjaja}</p>
            <p><strong>Lokacija:</strong> {dogadjaj.lokacija}</p>
            <p><strong>Datum:</strong> {dogadjaj.datum}</p>
            <p><strong>Status:</strong> {dogadjaj.status}</p>
            <p><strong>Opis:</strong> {dogadjaj.opis}</p>
            <button onClick={handleCloseModal} className="btn btn-secondary">
              Zatvori
            </button>
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