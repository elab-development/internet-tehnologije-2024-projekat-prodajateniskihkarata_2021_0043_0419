import axios from "axios";
import React, { useState, useEffect } from "react";
import OneEvent from "./OneEvent";
import "./Matches.css";

const Matches = () => {
  const [dogadjaji, setEvents] = useState([]);
  const [currentPage, setCurrentPage] = useState(1); // Trenutna stranica
  const [lastPage, setLastPage] = useState(1); // Ukupan broj stranica
  const [loading, setLoading] = useState(true); // Indikator za učitavanje

  const fetchEvents = async (page) => {
    setLoading(true);
    try {
      const res = await axios.get(`http://localhost:8000/api/dogadjaji?page=${page}`);
      const { data, last_page } = res.data;

      setEvents(data); // Postavljanje događaja sa trenutne stranice
      setLastPage(last_page); // Ažuriranje ukupnog broja stranica
      setCurrentPage(page); // Postavljanje trenutne stranice
    } catch (error) {
      console.error("Error fetching events:", error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchEvents(currentPage); // Učitavanje događaja pri inicijalizaciji
  }, []);

  const handlePreviousPage = () => {
    if (currentPage > 1) {
      fetchEvents(currentPage - 1);
    }
  };

  const handleNextPage = () => {
    if (currentPage < lastPage) {
      fetchEvents(currentPage + 1);
    }
  };

  return (
    <div className="matches">
      <h1 className="matches-title">Schedule of Events</h1>
      <p className="matches-paragraf">This is the schedule page where events are listed.</p>
      {loading ? (
        <p>Loading...</p>
      ) : dogadjaji.length === 0 ? (
        <p>No events available.</p>
      ) : (
        <>
          {dogadjaji.map((dogadjaj) => (
            <OneEvent key={dogadjaj.id} dogadjaj={dogadjaj} />
          ))}
          <div className="pagination">
            <button
              onClick={handlePreviousPage}
              disabled={currentPage === 1}
              className="btn btn-secondary"
            >
              Previous
            </button>
            <span className="page-info">
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
        </>
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
