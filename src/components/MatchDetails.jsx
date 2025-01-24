import React, { useEffect, useState } from 'react';
import { useParams } from 'react-router-dom'; // Za pristup parametru "id" iz URL-a
import axios from 'axios';

const MatchDetails = () => {
  const { id } = useParams(); // Uzimanje ID-a meča iz URL-a
  const [match, setMatch] = useState(null); // Čuvanje podataka o meču
  const [loading, setLoading] = useState(true); // Prikaz indikatora učitavanja
  const [error, setError] = useState(null); // Čuvanje eventualnih grešaka

  useEffect(() => {
    // Funkcija za učitavanje podataka o meču
    const fetchMatchDetails = async () => {
      try {
        const response = await axios.get(`http://localhost:8000/api/dogadjaji/${id}`);
        setMatch(response.data); // Postavljanje dobijenih podataka
      } catch (err) {
        setError("Ne možemo da pronađemo detalje o ovom meču.");
        console.error(err);
      } finally {
        setLoading(false); // Prestanak učitavanja
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

  return (
    <div className="match-details p-4">
      <h1 className="text-primary mb-4">Detalji o meču</h1>
      <p><strong>Naziv:</strong> {match.ime_dogadjaja}</p>
      <p><strong>Lokacija:</strong> {match.lokacija}</p>
      <p><strong>Datum:</strong> {match.datum_odrzavanja}</p>
      <p><strong>Status:</strong> {match.status}</p>
      <p><strong>Opis:</strong> {match.opis}</p>
    </div>
  );
};

export default MatchDetails;
