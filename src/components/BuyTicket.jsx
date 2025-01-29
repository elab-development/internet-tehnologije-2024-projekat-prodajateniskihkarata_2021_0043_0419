import React, { useState } from "react";
import TicketList from "./TicketList";
import TicketForm from "./TicketForm";
import Cart from "./Cart.jsx";
import "../App.css";

function BuyTickets() {
  const [selectedTicket, setSelectedTicket] = useState(null);
  const [cart, setCart] = useState([]);
  const [showCart, setShowCart] = useState(false);

  const tickets = [
    { id: 1, image: require("./slike/slikaterena1.jpg"), phase: "First Round", date: "25 Jan 2025", court: "Belgrade Arena Court 2", price: 10 },
    { id: 2, image: require("./slike/slikaterena2.jpg"), phase: "Second Round", date: "26 Jan 2025", court: "Belgrade Arena Court 1", price: 10 },
    { id: 3, image: require("./slike/slikaterena4.jpg"), phase: "Quarter Final", date: "25 Jan 2025", court: "Belgrade Arena Court 2", price: 20 },
    { id: 4, image: require("./slike/slikaterena3.jpg"), phase: "Semi Final", date: "25 Jan 2025", court: "Belgrade Arena Court 1", price: 30 },
    { id: 5, image: require("./slike/trofej.jpg"), phase: "Final", date: "25 Jan 2025", court: "Belgrade Arena Court 1", price: 50 },
  ];

  const handleBuyClick = (ticket) => {
    setSelectedTicket(ticket);
  };

  const handleCloseForm = () => {
    setSelectedTicket(null);
  };

  const handleAddToCart = (ticket, seatCategory, price) => {
    setCart((prevCart) => {
      const existingIndex = prevCart.findIndex((item) => item.phase === ticket.phase && item.seatCategory === seatCategory);

      if (existingIndex !== -1) {
        return prevCart.map((item, index) =>
          index === existingIndex ? { ...item, quantity: Math.min(item.quantity + 1, 5) } : item
        );
      }

      return [...prevCart, { ...ticket, seatCategory, price, quantity: 1 }];
    });

    setSelectedTicket(null);
  };

  const handleToggleCart = () => {
    setShowCart(!showCart);
  };

  return (
    <div className="buyTickets">
      <button className="cart-icon" onClick={handleToggleCart}>
        🛒 {cart.reduce((total, item) => total + item.quantity, 0)}
      </button>

      {!showCart ? (
        <TicketList tickets={tickets} onBuyClick={handleBuyClick} />
      ) : (
        <Cart cart={cart} setCart={setCart} setShowCart={setShowCart} />

      )}

      {selectedTicket && (
        <TicketForm ticket={selectedTicket} onClose={handleCloseForm} onAddToCart={handleAddToCart} />
      )}
    </div>
  );
}

export default BuyTickets;

