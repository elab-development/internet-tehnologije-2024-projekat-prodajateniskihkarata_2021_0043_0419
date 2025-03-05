import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom'; 
import axios from 'axios';
import './MatchDetails.css';

const MatchDetails = () => {
  const { id } = useParams(); // Uzimanje ID-a meča iz URL-a
  const [match, setMatch] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [showModal, setShowModal] = useState(false);

  useEffect(() => {
    const fetchMatchDetails = async () => {
      try {
        const response = await axios.get(`http://localhost:8000/api/dogadjaji/${id}`);
        setMatch(response.data);
      } catch (err) {
        setError("Ne možemo da pronađemo detalje o ovom meču.");
        console.error(err);
      } finally {
        setLoading(false);
      }
    };

    fetchMatchDetails();
  }, [id]);

  if (loading) {
    return <p>Učitavanje detalja o meču...</p>;
  }

  if (error) {
    return <p>{error}</p>;
  }

  const handleOpenModal = () => {
    setShowModal(true);
    document.body.classList.add("modal-open"); // Dodajemo klasu za onemogućavanje pozadine
  };

  const handleCloseModal = () => {
    setShowModal(false);
    document.body.classList.remove("modal-open"); // Uklanjamo klasu kada se modal zatvori
  };

  return (
    <div className="match-details p-4">
      <h1 className="text-primary mb-4">Detalji o meču</h1>
      <button onClick={handleOpenModal} className="btn btn-primary">
        Prikaz detalja
      </button>

      {showModal && (
        <div className="modal-overlay" onClick={handleCloseModal}>
          <div className="modal-content">
            <h2>Detalji o meču</h2>
            <p><strong>Naziv:</strong> {match.ime_dogadjaja}</p>
            <p><strong>Lokacija:</strong> {match.lokacija}</p>
            <p><strong>Datum:</strong> {match.datum}</p>
            <p><strong>Status:</strong> {match.status}</p>
            <p><strong>Opis:</strong> {match.opis}</p>
            <button onClick={handleCloseModal} className="btn btn-secondary">
              Zatvori
            </button>
          </div>
        </div>
      )}
    </div>
  );
};

export default MatchDetails;
