
import React, { useState } from "react";
import "./TicketForm.css";

function TicketForm({ ticket, onClose, onAddToCart }) {
  const [seatCategory, setSeatCategory] = useState("VIP");
  const [price, setPrice] = useState(ticket.price * 5);

  const handleCategoryChange = (event) => {
    const category = event.target.value;
    setSeatCategory(category);

    if (category === "VIP") setPrice(ticket.price * 5);
    else if (category === "East") setPrice(ticket.price * 2);
    else if (category === "West") setPrice(ticket.price);
  };

  return (
    <div className="ticket-form-overlay">
      <div className="ticket-form">
        <h2>Buy Ticket</h2>
        <p><strong>Phase:</strong> {ticket.phase}</p>
        <p><strong>Date:</strong> {ticket.date}</p>

        <label htmlFor="seat-category">Seat Category:</label>
        <select id="seat-category" value={seatCategory} onChange={handleCategoryChange}>
          <option value="VIP">VIP</option>
          <option value="East">East</option>
          <option value="West">West</option>
        </select>

        <p><strong>Price:</strong> ${price.toFixed(2)}</p>

        <div className="form-buttons">
          <button className="add-button" onClick={() => onAddToCart(ticket, seatCategory, price)}>Add to Cart</button>
          <button className="cancel-button" onClick={onClose}>Cancel</button>
        </div>
      </div>
    </div>
  );
}

export default TicketForm;
