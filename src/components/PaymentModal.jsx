// PaymentModal.jsx
import React, { useState } from 'react';
import './PaymentModal.css';
import { useLanguage } from '../contexts/LanguageContext'; // Uvozimo useLanguage


function PaymentModal({ onClose, onSuccess }) {
  const [paymentMode, setPaymentMode] = useState("selection");

  // Polja za kartično plaćanje
  const [cardholderName, setCardholderName] = useState("");
  const [cardNumber, setCardNumber] = useState("");
  const [cvv, setCvv] = useState("");
  const [expiry, setExpiry] = useState("");
  const [phone, setPhone] = useState("");

  // Polja za plaćanje na blagajni
  const [name, setName] = useState("");
  const [surname, setSurname] = useState("");
  const [address, setAddress] = useState("");
  const [cashierPhone, setCashierPhone] = useState("");

  const [error, setError] = useState("");

  const { language } = useLanguage();  // Koristimo jezik iz konteksta

  const translations = {
    en: {
      selectPaymentMethod: "Select Payment Method",
      cardPayment: "Card Payment",
      cashierPayment: "Pick Up at Cashier",
      confirm: "Confirm",
      back: "Back",
      purchaseSuccessful: "Purchase Successful!",
      thankYou: "Thank you for your purchase.",
      errorMessage: "Error, please check the fields."
    },
    sr: {
      selectPaymentMethod: "Izaberite način plaćanja",
      cardPayment: "Kartično plaćanje",
      cashierPayment: "Plaćanje na blagajni",
      confirm: "Potvrdi",
      back: "Nazad",
      purchaseSuccessful: "Kupovina uspešna!",
      thankYou: "Hvala na kupovini.",
      errorMessage: "Greška, proverite polja."
    },
  };

  // Validacija za kartično plaćanje
  const validateCardPayment = () => {
    const nameRegex = /^[A-Za-z\s]+$/;
    if (!nameRegex.test(cardholderName) || cardholderName.trim() === "") {
      return "Invalid cardholder name";
    }
    const cardNumberRegex = /^[0-9]{16}$/;
    if (!cardNumberRegex.test(cardNumber)) {
      return "Invalid card number (should be 16 digits)";
    }
    const cvvRegex = /^[0-9]{3}$/;
    if (!cvvRegex.test(cvv)) {
      return "Invalid CVV (should be 3 digits)";
    }
    const expiryRegex = /^(0[1-9]|1[0-2])\/([2-9][5-9])$/; // format MM/YY, mesec 01-12, godina od 25
    if (!expiryRegex.test(expiry)) {
      return "Invalid expiry date (format MM/YY, month 01-12, year 25+)";
    }
    const phoneRegex = /^06\d{6,10}$/; // mora početi sa 06, ukupno 8-12 cifara
    if (!phoneRegex.test(phone)) {
      return "Invalid phone number (must start with 06 and have 8-12 digits)";
    }
    return "";
  };

  // Validacija za plaćanje na blagajni
  const validateCashierPayment = () => {
    const nameRegex = /^[A-Za-z\s]+$/;
    if (!nameRegex.test(name) || name.trim() === "") {
      return "Invalid name";
    }
    if (!nameRegex.test(surname) || surname.trim() === "") {
      return "Invalid surname";
    }
    const addressRegex = /^[A-Za-z0-9\s]+$/;
    if (!addressRegex.test(address) || address.trim() === "") {
      return "Invalid address";
    }
    const phoneRegex = /^06\d{6,10}$/;
    if (!phoneRegex.test(cashierPhone)) {
      return "Invalid phone number (must start with 06 and have 8-12 digits)";
    }
    return "";
  };

  const handleCardConfirm = async () => {
    const validationError = validateCardPayment();
    if (validationError) {
      setError(validationError);
      return;
    }
    setError("");
    
    const paymentData = {
      korisnik_id: 1,  // Ovdje treba koristiti trenutnog korisnika (ako je ulogovan)
      iznos: 700,  // Primer iznosa
      datum_transakcije: "2025-01-14 14:00:00",  // Primer datuma
      status_transakcije: "pending",  // Status može biti promenljiv
      tip_placanja: "debit_card",  // Ovaj tip treba da odgovara selektovanom načinu plaćanja
    };

    await savePaymentToDatabase(paymentData);
    setPaymentMode("success");
  };

  const handleCashierConfirm = async () => {
    const validationError = validateCashierPayment();
    if (validationError) {
      setError(validationError);
      return;
    }
    setError("");
    
    const paymentData = {
      korisnik_id: 1,  // Ovdje treba koristiti trenutnog korisnika (ako je ulogovan)
      iznos: 700,  // Primer iznosa
      datum_transakcije: "2025-01-14 14:00:00",  // Primer datuma
      status_transakcije: "pending",  // Status može biti promenljiv
      tip_placanja: "cashier",  // Plaćanje na blagajni
    };

    await savePaymentToDatabase(paymentData);
    setPaymentMode("success");
  };

  const savePaymentToDatabase = async (paymentData) => {
    try {
      const response = await fetch('http://localhost:8000/api/placanja', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Authorization': `Bearer ${localStorage.getItem('token')}`,  // Ako koristiš token za autentifikaciju
        },
        body: JSON.stringify(paymentData),
      });

      const result = await response.json();
      if (response.ok) {
        console.log("Payment created successfully:", result);
      } else {
        console.error("Error creating payment:", result.message);
      }
    } catch (err) {
      console.error("Failed to connect to the server:", err);
    }
  };

  const renderSelection = () => (
    <div className="payment-content">
      <h2>{translations[language].selectPaymentMethod}</h2>
      <div className="payment-options">
        <button onClick={() => setPaymentMode("card")}>{translations[language].cardPayment}</button>
        <button onClick={() => setPaymentMode("cashier")}>{translations[language].cashierPayment}</button>
      </div>
      <button className="back-btn" onClick={onClose}>{translations[language].back}</button>
    </div>
  );
  

  const renderCardPayment = () => (
    <div className="payment-content">
      <h2>{translations[language].cardPayment}</h2>
      <input
        type="text"
        placeholder="Cardholder Name"
        value={cardholderName}
        onChange={(e) => setCardholderName(e.target.value)}
      />
      <input
        type="text"
        placeholder="Card Number (16 digits)"
        value={cardNumber}
        onChange={(e) => setCardNumber(e.target.value)}
      />
      <input
        type="text"
        placeholder="CVV (3 digits)"
        value={cvv}
        onChange={(e) => setCvv(e.target.value)}
      />
      <input
        type="text"
        placeholder="Expiry Date (MM/YY)"
        value={expiry}
        onChange={(e) => setExpiry(e.target.value)}
      />
      <input
        type="text"
        placeholder="Phone Number"
        value={phone}
        onChange={(e) => setPhone(e.target.value)}
      />
      {error && <p className="error">{translations[language].errorMessage}</p>}
      <div className="payment-buttons">
        <button onClick={handleCardConfirm}>{translations[language].confirm}</button>
        <button className="back-btn" onClick={() => { setPaymentMode("selection"); setError(""); }}>{translations[language].back}</button>
      </div>
    </div>
  );

  const renderCashierPayment = () => (
    <div className="payment-content">
      <h2>{translations[language].cashierPayment}</h2>
      <input
        type="text"
        placeholder="Name"
        value={name}
        onChange={(e) => setName(e.target.value)}
      />
      <input
        type="text"
        placeholder="Surname"
        value={surname}
        onChange={(e) => setSurname(e.target.value)}
      />
      <input
        type="text"
        placeholder="Address"
        value={address}
        onChange={(e) => setAddress(e.target.value)}
      />
      <input
        type="text"
        placeholder="Phone Number"
        value={cashierPhone}
        onChange={(e) => setCashierPhone(e.target.value)}
      />
      {error && <p className="error">{translations[language].errorMessage}</p>}
      <div className="payment-buttons">
        <button onClick={handleCashierConfirm}>{translations[language].confirm}</button>
        <button className="back-btn" onClick={() => { setPaymentMode("selection"); setError(""); }}>{translations[language].back}</button>
      </div>
    </div>
  );

  const renderSuccess = () => (
    <div className="payment-content success">
      <h2>{translations[language].purchaseSuccessful}</h2>
      <div className="success-icon">✔️</div>
      <p>{translations[language].thankYou}</p>
      <button onClick={onSuccess}>OK</button>
    </div>
  );

  return (
    <div className="payment-modal-overlay">
      <div className="payment-modal">
        {paymentMode === "selection" && renderSelection()}
        {paymentMode === "card" && renderCardPayment()}
        {paymentMode === "cashier" && renderCashierPayment()}
        {paymentMode === "success" && renderSuccess()}
      </div>
    </div>
  );
}

export default PaymentModal;
