import React from "react";
import "./TicketCard.css";

function TicketCard({ image, phase, date, court, price, onBuyClick }) {
  return (
    <div className="ticket-card">
      <img src={image} alt={`${phase}`} className="ticket-image" />
      <div className="ticket-body">
        <h3>{phase}</h3>
        <p>{date}</p>
        <p>{court}</p>
        <p className="ticket-price">{price}</p>
        <div className="ticket-buttons">
          <button className="buy-button" onClick={() => onBuyClick({ image, phase, date, court, price })}>
            Buy Ticket
          </button>
          <button className="info-button">More Info</button>
        </div>
      </div>
    </div>
  );
}

export default TicketCard;