import React from "react";
import TicketCard from "./TicketCard";
import "./TicketList.css";

function TicketList({ tickets, onBuyClick }) {
  return (
    <div className="ticket-list">
      {tickets.map((ticket) => (
        <TicketCard key={ticket.id} {...ticket} onBuyClick={onBuyClick} />
      ))}
    </div>
  );
}

export default TicketList;