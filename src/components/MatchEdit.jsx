import React, { useEffect, useState } from "react";
import axios from "axios";
import { useParams, useNavigate } from "react-router-dom";
import "./MatchEdit.css";

const MatchEdit = () => {
  const { id } = useParams();
  const navigate = useNavigate();
  const [formData, setFormData] = useState({
    ime_dogadjaja: "",
    lokacija: "",
    opis: "",
    status: "zakazan",
    datum_registracije: "",
  });
  const [error, setError] = useState(null);
  const [successMessage, setSuccessMessage] = useState('');

  useEffect(() => {
    const fetchMatch = async () => {
      try {
        const response = await axios.get(
          `http://localhost:8000/api/dogadjaji/${id}`
        );
        setFormData(response.data);
      } catch (err) {
        setError("Došlo je do greške prilikom učitavanja meča");
      }
    };

    fetchMatch();
  }, [id]);

  const handleChange = (e) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    const formattedDate = new Date(formData.datum_registracije)
      .toISOString()
      .split("T")[0];

    const updatedData = {
      ...formData,
      datum_registracije: formattedDate,
    };

    try {
      const token = localStorage.getItem("token");
      if (!token) {
        alert("Niste ulogovani!");
        return;
      }

      const response = await axios.put(
        `http://localhost:8000/api/dogadjaji/${id}`,
        updatedData,
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );

      // Postavljanje poruke nakon uspešnog ažuriranja
      setSuccessMessage("Uspešno ažurirano!");

      // Navigacija na detalje meča
      setTimeout(() => {
        navigate(`/matches/${id}`);
      }, 1500); // Sačekaj 1.5 sekunde pre nego što se izvrši navigacija

      console.info("Uspesno azurirano");
    } catch (err) {
      console.error("Došlo je do greške prilikom izmene meča", err);
      setError("Došlo je do greške prilikom izmene meča");
    }
  };

  const handleCancel = () => {
    navigate("/matches");
  };

  if (error) {
    return <div className="match-edit-error">{error}</div>;
  }

  return (
    <div className="match-edit-container">
      <h2 className="match-edit-title">Izmeni Meč</h2>
      <form className="match-edit-form" onSubmit={handleSubmit}>
        <label className="match-edit-label">
          Ime Događaja:
          <input
            type="text"
            name="ime_dogadjaja"
            value={formData.ime_dogadjaja}
            onChange={handleChange}
            className="match-edit-input"
          />
        </label>
        <label className="match-edit-label">
          Lokacija:
          <input
            type="text"
            name="lokacija"
            value={formData.lokacija}
            onChange={handleChange}
            className="match-edit-input"
          />
        </label>
        <label className="match-edit-label">
          Opis:
          <textarea
            name="opis"
            value={formData.opis}
            onChange={handleChange}
            className="match-edit-textarea"
          />
        </label>
        <label className="match-edit-label">
          Status:
          <select
            name="status"
            value={formData.status}
            onChange={handleChange}
            className="match-edit-select"
          >
            <option value="zakazan">Zakazan</option>
            <option value="odrzan">Odrzan</option>
            <option value="otkazan">Otkazan</option>
          </select>
        </label>
        <label className="match-edit-label">
          Datum registracije:
          <input
            type="date"
            name="datum_registracije"
            value={formData.datum_registracije}
            onChange={handleChange}
            className="match-edit-input"
          />
        </label>
        <button type="submit" className="match-edit-submit">
          Ažuriraj Meč
        </button>
        <button
          type="button"
          onClick={handleCancel}
          className="match-edit-cancel"
        >
          Odustani
        </button>
      </form>
    </div>
  );
};

export default MatchEdit;
