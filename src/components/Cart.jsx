import React, { useContext } from "react";
import "./Cart.css";
import { UserContext } from "../contexts/UserContext";
import { useLanguage } from "../contexts/LanguageContext"; // Uvozimo useLanguage

function Cart({ cart, setCart, setShowCart, onConfirmPurchase }) {
  const { user } = useContext(UserContext);
  const { language } = useLanguage();  // Koristimo jezik iz konteksta
  const isAuthorized = user && (user.uloga === "admin" || user.uloga === "auth_user");

  const translations = {
    en: {
      shoppingCart: "Shopping Cart 🛒",
      emptyCart: "Your cart is empty.",
      totalAmount: "Total:",
      confirmPurchase: "Confirm Purchase",
      backToCatalog: "Back to Catalog",
      loginAlert: "You must be logged in to complete the purchase!",
    },
    sr: {
      shoppingCart: "Korpica 🛒",
      emptyCart: "Vaša korpa je prazna.",
      totalAmount: "Ukupno:",
      confirmPurchase: "Potvrdi kupovinu",
      backToCatalog: "Vrati se na katalog",
      loginAlert: "Morate biti ulogovani da biste obavili kupovinu!",
    },
  };

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

  const handlePurchaseClick = () => {
    if (!isAuthorized) {
      alert(translations[language].loginAlert);
      return;
    }
    onConfirmPurchase(totalAmount);
  };

  return (
    <div className="cart">
      <h2>{translations[language].shoppingCart}</h2>
      {cart.length === 0 ? (
        <p>{translations[language].emptyCart}</p>
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
                  <button className="remove-btn" onClick={() => handleRemove(index)}>
                    Remove
                  </button>
                </div>
              </div>
            </div>
          ))}
        </div>
      )}
      <h3 className="total-amount">{translations[language].totalAmount} ${totalAmount.toFixed(2)}</h3>
      <button className="confirm-btn" onClick={handlePurchaseClick}>
        {translations[language].confirmPurchase}
      </button>
      <button className="back-btn" onClick={() => setShowCart(false)}>
        {translations[language].backToCatalog}
      </button>
    </div>
  );
}

export default Cart;
