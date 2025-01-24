import React, { useState, useEffect } from "react";
import axios from "axios";
import OneEvent from "./OneEvent";
import "./Matches.css";

const Matches = () => {
  const [dogadjaji, setDogadjaji] = useState([]);
  const [filters, setFilters] = useState({ naziv: "", lokacija: "", status: "" });
  const [currentPage, setCurrentPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const [loading, setLoading] = useState(false);

  const fetchEvents = async (page = 1, filters = {}) => {
    setLoading(true);
    try {
      const res = await axios.get("http://localhost:8000/api/dogadjaji/pretraga", {
        params: { ...filters, page },
      });
      const { data, last_page } = res.data;

      setDogadjaji(data);
      setLastPage(last_page);
      setCurrentPage(page);
    } catch (error) {
      console.error("Error fetching events:", error);
    } finally {
      setLoading(false);
    }
  };

  const handleFilterChange = (e) => {
    setFilters({
      ...filters,
      [e.target.name]: e.target.value,
    });
  };

  const handleSearch = (e) => {
    e.preventDefault();
    setCurrentPage(1);
    fetchEvents(1, filters);
  };

  const handlePreviousPage = () => {
    if (currentPage > 1) {
      fetchEvents(currentPage - 1, filters);
    }
  };

  const handleNextPage = () => {
    if (currentPage < lastPage) {
      fetchEvents(currentPage + 1, filters);
    }
  };

  useEffect(() => {
    fetchEvents(currentPage, filters);
  }, []);

  return (
    <div className="matches">
      <h1 className="matches-title text-center text-white">Schedule of Events</h1>

      {/* Filter form */}
      <form className="filter-form p-3 bg-dark text-white rounded" onSubmit={handleSearch}>
        <h2 className="text-white mb-3">Filtrirajte događaje:</h2>
        <div className="form-group">
          <label htmlFor="naziv">Naziv:</label>
          <input
            type="text"
            id="naziv"
            name="naziv"
            value={filters.naziv}
            onChange={handleFilterChange}
            className="form-control"
            placeholder="Unesite naziv događaja"
          />
        </div>
        <div className="form-group">
          <label htmlFor="lokacija">Lokacija:</label>
          <input
            type="text"
            id="lokacija"
            name="lokacija"
            value={filters.lokacija}
            onChange={handleFilterChange}
            className="form-control"
            placeholder="Unesite lokaciju"
          />
        </div>
        <div className="form-group">
          <label htmlFor="status">Status:</label>
          <select
            id="status"
            name="status"
            value={filters.status}
            onChange={handleFilterChange}
            className="form-control"
          >
            <option value="">-- Svi Statusi --</option>
            <option value="zakazan">Zakazan</option>
            <option value="odrzan">Održan</option>
            <option value="otkazan">Otkazan</option>
          </select>
        </div>
        <button type="submit" className="btn btn-primary mt-3">
          Pretraži
        </button>
      </form>

      {/* Results */}
      {loading ? (
        <p className="text-center text-white">Loading...</p>
      ) : dogadjaji.length === 0 ? (
        <p className="text-center text-white">Nema događaja za zadate kriterijume.</p>
      ) : (
        <div className="events-list mt-4">
          {dogadjaji.map((dogadjaj) => (
            <OneEvent key={dogadjaj.id} dogadjaj={dogadjaj} />
          ))}
          <div className="pagination d-flex justify-content-between align-items-center mt-4">
            <button
              onClick={handlePreviousPage}
              disabled={currentPage === 1}
              className="btn btn-secondary"
            >
              Previous
            </button>
            <span className="text-white">
              Page {currentPage} of {lastPage}
            </span>
            <button
              onClick={handleNextPage}
              disabled={currentPage === lastPage}
              className="btn btn-secondary"
            >
              Next
            </button>
          </div>
        </div>
      )}
    </div>
  );
};

export default Matches;



// import axios from "axios";
// import React from "react";
// import OneEvent from "./OneEvent";
// import { useState } from "react";
// import "./Matches.css";

// const Matches = () => {
//   const [dogadjaji, setEvents] = useState();
//   axios.get("http://localhost:8000/api/dogadjaji").then((res)=>{
//     console.log(res.data);
//     setEvents(res.data.data);
//   })
//   return (
//     <div className="matches">
//       <h1>Schedule of Events</h1>
//       <p>This is the schedule page where events are listed.</p>
//       {dogadjaji == null ? <></> : dogadjaji.map((dogadjaj) => (
//         <OneEvent dogadjaj={dogadjaj} />
//       ))}
//     </div>
//   );
// };

// export default Matches;
