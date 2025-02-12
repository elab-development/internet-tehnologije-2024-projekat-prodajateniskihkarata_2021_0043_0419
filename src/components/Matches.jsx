import React, { useState, useEffect, useContext } from "react";
import axios from "axios";
import OneEvent from "./OneEvent";
import { UserContext } from "../contexts/UserContext";
import { useLanguage } from "../contexts/LanguageContext"; // Dodata podrška za jezike
import "./Matches.css";

const Matches = () => {
  const [dogadjaji, setDogadjaji] = useState([]);
  const [filters, setFilters] = useState({ naziv: "", lokacija: "", status: "" });
  const [currentPage, setCurrentPage] = useState(1);
  const [lastPage, setLastPage] = useState(1);
  const [loading, setLoading] = useState(false);

  const { user } = useContext(UserContext);
  const { language } = useLanguage();
  const isAdmin = user?.uloga === "admin";

  const translations = {
    en: {
      schedule: "Schedule of Events",
      filter: "Filter events:",
      title: "Title:",
      location: "Location:",
      status: "Status:",
      allStatus: "-- All status --",
      scheduled: "Scheduled",
      held: "Held",
      canceled: "Canceled",
      search: "Search",
      loading: "Loading...",
      noEvents: "No events match the given criteria.",
      page: "Page",
      of: "of",
      previous: "Previous",
      next: "Next",
      download: "Download all matches:",
      downloadPDF: "Download PDF",
      downloadICS: "Download ICS",
      downloadCSV: "Download CSV",
    },
    sr: {
      schedule: "Raspored događaja",
      filter: "Filtriraj događaje:",
      title: "Naziv:",
      location: "Lokacija:",
      status: "Status:",
      allStatus: "-- Svi statusi --",
      scheduled: "Zakazan",
      held: "Održan",
      canceled: "Otkazan",
      search: "Pretraži",
      loading: "Učitavanje...",
      noEvents: "Nema događaja za zadate kriterijume.",
      page: "Strana",
      of: "od",
      previous: "Prethodna",
      next: "Sledeća",
      download: "Preuzmite sve mečeve:",
      downloadPDF: "Preuzmi PDF",
      downloadICS: "Preuzmi ICS",
      downloadCSV: "Preuzmi CSV",
    },
  };

  const fetchEvents = async (page = 1, filters = {}) => {
    setLoading(true);
    try {
      const res = await axios.get("http://localhost:8000/api/dogadjaji/pretraga", {
        params: { ...filters, page },
      });
      setDogadjaji(res.data.data);
      setLastPage(res.data.last_page || 1);
      setCurrentPage(page);
    } catch (error) {
      console.error("Error fetching events:", error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchEvents(currentPage, filters);
  }, []); // Fetching samo jednom prilikom mount-a

  const handleFilterChange = (e) => {
    const updatedFilters = {
      ...filters,
      [e.target.name]: e.target.value,
    };
    setFilters(updatedFilters);
    fetchEvents(1, updatedFilters); // Automatsko filtriranje prilikom promene
    setCurrentPage(1); // Resetovanje na prvu stranu prilikom filtiranja
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

  return (
    <div className="matches">
      <h1 className="matches-title text-center text-white">
        {translations[language].schedule}
      </h1>

      {/* Filter form */}
      <form className="filter-form p-3 bg-dark text-white rounded">
        <h2 className="text-white mb-3">{translations[language].filter}</h2>
        <div className="form-group">
          <label htmlFor="naziv">{translations[language].title}</label>
          <input
            type="text"
            id="naziv"
            name="naziv"
            value={filters.naziv}
            onChange={handleFilterChange}
            className="form-control"
            placeholder={translations[language].title}
          />
        </div>
        <div className="form-group">
          <label htmlFor="lokacija">{translations[language].location}</label>
          <input
            type="text"
            id="lokacija"
            name="lokacija"
            value={filters.lokacija}
            onChange={handleFilterChange}
            className="form-control"
            placeholder={translations[language].location}
          />
        </div>
        <div className="form-group">
          <label htmlFor="status">{translations[language].status}</label>
          <select
            id="status"
            name="status"
            value={filters.status}
            onChange={handleFilterChange}
            className="form-control"
          >
            <option value="">{translations[language].allStatus}</option>
            <option value="zakazan">{translations[language].scheduled}</option>
            <option value="odrzan">{translations[language].held}</option>
            <option value="otkazan">{translations[language].canceled}</option>
          </select>
        </div>
      </form>

      {/* Pagination */}
      <div className="pagination d-flex justify-content-between align-items-center mt-3">
        <button onClick={handlePreviousPage} disabled={currentPage === 1} className="btn btn-secondary">
          {translations[language].previous}
        </button>
        <span className="text-white">
          {translations[language].page} {currentPage} {translations[language].of} {lastPage}
        </span>
        <button onClick={handleNextPage} disabled={currentPage === lastPage} className="btn btn-secondary">
          {translations[language].next}
        </button>
      </div>

      {/* Results */}
      {loading ? (
        <p className="text-center text-white">{translations[language].loading}</p>
      ) : dogadjaji.length === 0 ? (
        <p className="text-center text-white">{translations[language].noEvents}</p>
      ) : (
        <div className="events-list mt-4">
          {dogadjaji.map((dogadjaj) => (
            <OneEvent key={dogadjaj.id} dogadjaj={dogadjaj} isAdmin={isAdmin} />
          ))}
        </div>
      )}

      {/* Pagination */}
      <div className="pagination d-flex justify-content-between align-items-center mt-3">
        <button onClick={handlePreviousPage} disabled={currentPage === 1} className="btn btn-secondary">
          {translations[language].previous}
        </button>
        <span className="text-white">
          {translations[language].page} {currentPage} {translations[language].of} {lastPage}
        </span>
        <button onClick={handleNextPage} disabled={currentPage === lastPage} className="btn btn-secondary">
          {translations[language].next}
        </button>
      </div>

      {/* Download buttons */}
      <div className="download-buttons mt-4">
        <h3 className="text-white">{translations[language].download}</h3>
        <a href="http://localhost:8000/eksport/pdf" className="btn btn-danger mt-2">
          {translations[language].downloadPDF}
        </a>
        <a href="http://localhost:8000/eksport/ics" className="btn btn-success mt-2">
          {translations[language].downloadICS}
        </a>
        <a href="http://localhost:8000/eksport/csv" className="btn btn-warning mt-2">
          {translations[language].downloadCSV}
        </a>
      </div>
    </div>
  );
};

export default Matches;


// STARA VERZIJA BEZ PREVODA

// import React, { useState, useEffect, useContext } from "react";
// import axios from "axios";
// import OneEvent from "./OneEvent";
// import { UserContext } from "../contexts/UserContext"; // Ispravan import
// import "./Matches.css";

// const Matches = () => {
//   const [dogadjaji, setDogadjaji] = useState([]);
//   const [filters, setFilters] = useState({ naziv: "", lokacija: "", status: "" });
//   const [currentPage, setCurrentPage] = useState(1);
//   const [lastPage, setLastPage] = useState(1);
//   const [loading, setLoading] = useState(false);

//   const { user } = useContext(UserContext); // Dobijamo korisničke podatke
//   const isAdmin = user?.uloga === "admin";

//   const fetchEvents = async (page = 1, filters = {}) => {
//     setLoading(true);
//     try {
//       const res = await axios.get("http://localhost:8000/api/dogadjaji/pretraga", {
//         params: { ...filters, page },
//       });
//       const { data, last_page } = res.data;

//       setDogadjaji(data);
//       setLastPage(last_page);
//       setCurrentPage(page);
//     } catch (error) {
//       console.error("Error fetching events:", error);
//     } finally {
//       setLoading(false);
//     }
//   };

//   const handleFilterChange = (e) => {
//     setFilters({
//       ...filters,
//       [e.target.name]: e.target.value,
//     });
//   };

//   const handleSearch = (e) => {
//     e.preventDefault();
//     setCurrentPage(1);
//     fetchEvents(1, filters);
//   };

//   const handlePreviousPage = () => {
//     if (currentPage > 1) {
//       fetchEvents(currentPage - 1, filters);
//     }
//   };

//   const handleNextPage = () => {
//     if (currentPage < lastPage) {
//       fetchEvents(currentPage + 1, filters);
//     }
//   };

//   useEffect(() => {
//     fetchEvents(currentPage, filters);
//   }, [currentPage, filters]);

//   return (
//     <div className="matches">
//       <h1 className="matches-title text-center text-white">Schedule of Events</h1>

//       {/* Filter form */}
//       <form className="filter-form p-3 bg-dark text-white rounded" onSubmit={handleSearch}>
//         <h2 className="text-white mb-3">Filter events:</h2>
//         <div className="form-group">
//           <label htmlFor="naziv">Title:</label>
//           <input
//             type="text"
//             id="naziv"
//             name="naziv"
//             value={filters.naziv}
//             onChange={handleFilterChange}
//             className="form-control"
//             //placeholder="Unesite naziv događaja"
//             placeholder="Enter a name of event"
//           />
//         </div>
//         <div className="form-group">
//           <label htmlFor="lokacija">Location:</label>
//           <input
//             type="text"
//             id="lokacija"
//             name="lokacija"
//             value={filters.lokacija}
//             onChange={handleFilterChange}
//             className="form-control"
//             //placeholder="Unesite lokaciju"
//             placeholder="Enter a location"
//           />
//         </div>
//         <div className="form-group">
//           <label htmlFor="status">Status:</label>
//           <select
//             id="status"
//             name="status"
//             value={filters.status}
//             onChange={handleFilterChange}
//             className="form-control"
//           >
//             <option value="">-- All status --</option>
//             <option value="zakazan">Zakazan</option>
//             <option value="odrzan">Održan</option>
//             <option value="otkazan">Otkazan</option>
//           </select>
//         </div>
//         <button type="submit" className="btn btn-primary mt-3">
//           Search
//         </button>
//       </form>


//       {/* Pagination below filter form */}
//       <div className="pagination d-flex justify-content-between align-items-center mt-3">
//         <button
//           onClick={handlePreviousPage}
//           disabled={currentPage === 1}
//           className="btn btn-secondary"
//         >
//           Previous
//         </button>
//         <span className="text-white">
//           Page {currentPage} of {lastPage}
//         </span>
//         <button
//           onClick={handleNextPage}
//           disabled={currentPage === lastPage}
//           className="btn btn-secondary"
//         >
//           Next
//         </button>
//       </div>

//       {/* Results */}
//       {loading ? (
//         <p className="text-center text-white">Loading...</p>
//       ) : dogadjaji.length === 0 ? (
//         <p className="text-center text-white">Nema događaja za zadate kriterijume.</p>
//       ) : (
//         <div className="events-list mt-4">
//           {dogadjaji.map((dogadjaj) => (
//             <OneEvent key={dogadjaj.id} dogadjaj={dogadjaj} isAdmin={isAdmin} />
//           ))}
//           <div className="pagination d-flex justify-content-between align-items-center mt-4">
//             <button
//               onClick={handlePreviousPage}
//               disabled={currentPage === 1}
//               className="btn btn-secondary"
//             >
//               Previous
//             </button>
//             <span className="text-white">
//               Page {currentPage} of {lastPage}
//             </span>
//             <button
//               onClick={handleNextPage}
//               disabled={currentPage === lastPage}
//               className="btn btn-secondary"
//             >
//               Next
//             </button>
//           </div>
//         </div>
//       )}

//       {/* Download buttons */}
//       <div className="download-buttons mt-4">
//         <h3 className="text-white">Preuzmite sve mečeve:</h3>
//         <a href="http://localhost:8000/eksport/pdf" className="btn btn-danger mt-2">Preuzmi PDF</a>
//         <a href="http://localhost:8000/eksport/ics" className="btn btn-success mt-2">Preuzmi ICS</a>
//         <a href="http://localhost:8000/eksport/csv" className="btn btn-warning mt-2">Preuzmi CSV</a>
//       </div>
//     </div>
//   );
// };

// export default Matches;













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
