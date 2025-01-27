
import React, { useState } from "react";
import TicketList from "./TicketList";
import TicketForm from "./TicketForm";
import "../App.css";

function BuyTickets() {
    const [selectedTicket, setSelectedTicket] = useState(null);
    const tickets = [
    {
      id: 1,
      image: require("./slike/slikaterena1.jpg"),
      phase: "First Round",
      date: "25 Jan 2025",
      court: "Belgrade Arena Court 2",
      price: "Starting from $10.00",
    },
    {
      id: 2,
      image: require("./slike/slikaterena2.jpg"),
      phase: "Second Round",
      date: "26 Jan 2025",
      court: "Belgrade Arena Court 1",
      price: "Starting from $10.00",
    },
    {
        id: 3,
        image: require("./slike/slikaterena4.jpg"),
        phase: "Quarter Final",
        date: "25 Jan 2025",
        court: "Belgrade Arena Court 2",
        price: "Starting from $20.00",
      },
      {
        id: 4,
        image: require("./slike/slikaterena3.jpg"),
        phase: "Semi Final",
        date: "25 Jan 2025",
        court: "Belgrade Arena Court 1",
        price: "Starting from $30.00",
      },
      {
        id: 1,
        image: require("./slike/trofej.jpg"),
        phase: "Final",
        date: "25 Jan 2025",
        court: "Belgrade Arena Court 1",
        price: "Starting from $50.00",
      },
  ];

  const handleBuyClick = (ticket) => {
    setSelectedTicket(ticket);
  };

  const handleCloseForm = () => {
    setSelectedTicket(null);
  };

  return (
    <div className="buyTickets">
     
      <TicketList tickets={tickets} onBuyClick={handleBuyClick} />
      {selectedTicket && <TicketForm ticket={selectedTicket} onClose={handleCloseForm} />}
    </div>
  );
}

export default BuyTickets;