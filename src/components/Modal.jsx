// import React from "react";
// import "./Modal.css"; // Kreiraj CSS za modal

// const Modal = ({ dogadjaj, closeModal }) => {
//   return (
//     <div className="modal-overlay">
//       <div className="modal-content">
//         <h2>{dogadjaj.ime_dogadjaja}</h2>
//         <p><strong>Lokacija:</strong> {dogadjaj.lokacija}</p>
//         <p><strong>Datum:</strong> {dogadjaj.datum}</p>
//         <p><strong>Status:</strong> {dogadjaj.status}</p>
//         <p><strong>Opis:</strong> {dogadjaj.opis}</p>
//         <button className="btn btn-secondary" onClick={closeModal}>Zatvori</button>
//       </div>
//     </div>
//   );
// };

// export default Modal;
import React from 'react';
import './Modal.css';

const Modal = ({ showModal, closeModal, content }) => {
  if (!showModal) return null;

  return (
    <div className="modal-overlay" onClick={closeModal}>
      <div className="modal-content" onClick={(e) => e.stopPropagation()}>
        {content}
        <button onClick={closeModal} className="btn btn-secondary">Zatvori</button>
      </div>
    </div>
  );
};

export default Modal;
