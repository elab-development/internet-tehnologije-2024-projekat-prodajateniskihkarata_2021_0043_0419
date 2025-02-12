// Cart.jsx
import React from "react";
import "./Cart.css";

function Cart({ cart, setCart, setShowCart, onConfirmPurchase }) {
  const totalAmount = cart.reduce((sum, item) => sum + item.quantity * item.price, 0);

  const handleIncrease = (index) => {
    setCart((prevCart) =>
      prevCart.map((item, i) =>
        i === index ? { ...item, quantity: Math.min(item.quantity + 1, 5) } : item
      )
    );
  };

  const handleDecrease = (index) => {
    setCart((prevCart) =>
      prevCart
        .map((item, i) =>
          i === index ? { ...item, quantity: item.quantity > 1 ? item.quantity - 1 : 1 } : item
        )
        .filter((item) => item.quantity > 0)
    );
  };

  const handleRemove = (index) => {
    setCart((prevCart) => prevCart.filter((_, i) => i !== index));
  };

  return (
    <div className="cart">
      <h2>Shopping Cart 🛒</h2>
      {cart.length === 0 ? (
        <p>Your cart is empty.</p>
      ) : (
        <div className="cart-items">
          {cart.map((item, index) => (
            <div key={index} className="cart-item">
              <img src={item.image} alt={item.phase} className="cart-image" />
              <div className="cart-details">
                <p><strong>{item.phase}</strong></p>
                <p>Category: {item.seatCategory}</p>
                <p>Price: ${item.price.toFixed(2)}</p>
                <p>Quantity: {item.quantity}</p>
                <div className="cart-controls">
                  <button onClick={() => handleDecrease(index)}>-</button>
                  <button onClick={() => handleIncrease(index)}>+</button>
                  <button className="remove-btn" onClick={() => handleRemove(index)}>Remove</button>
                </div>
              </div>
            </div>
          ))}
        </div>
      )}
      <h3 className="total-amount">Total: ${totalAmount.toFixed(2)}</h3>
      <button className="confirm-btn" onClick={() => onConfirmPurchase(totalAmount)}>
        Confirm Purchase
      </button>
      <button className="back-btn" onClick={() => setShowCart(false)}>Back to Catalog</button>
    </div>
  );
}

export default Cart;
