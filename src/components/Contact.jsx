import React, { useState } from 'react';
import axios from 'axios';
import { useLanguage } from '../contexts/LanguageContext'; // Dodata podrška za jezike

const Contact = () => {
  const [file, setFile] = useState(null);
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    message: ''
  });

  const { language } = useLanguage(); // Koristi language iz context-a

  const translations = {
    en: {
      contactUs: "Contact Us",
      name: "Name",
      email: "Email",
      message: "Message",
      uploadFile: "Upload File",
      send: "Send",
      success: "File and form data uploaded successfully",
      failure: "Failed to upload file and form data"
    },
    sr: {
      contactUs: "Kontaktirajte nas",
      name: "Ime",
      email: "Email",
      message: "Poruka",
      uploadFile: "Otpremite fajl",
      send: "Pošaljite",
      success: "Fajl i podaci su uspešno poslati",
      failure: "Došlo je do greške prilikom slanja fajla i podataka"
    }
  };

  const handleInputChange = (e) => {
    const { name, value } = e.target;
    setFormData({
      ...formData,
      [name]: value
    });
  };

  const handleFileChange = (e) => {
    setFile(e.target.files[0]);
  };

  const handleSubmit = async (e) => {
    e.preventDefault();

    const data = new FormData();
    data.append('name', formData.name);
    data.append('email', formData.email);
    data.append('message', formData.message);
    if (file) {
      data.append('file', file);
    }

    try {
      const response = await axios.post('http://127.0.0.1:8000/api/upload-fajlova', data, {
        headers: {
          'Content-Type': 'multipart/form-data'
        }
      });
      console.log(response.data);
      alert(translations[language].success);
    } catch (error) {
      console.error('Error uploading file and form data:', error);
      alert(translations[language].failure);
    }
  };

  return (
    <div className="contact-container">
      <h1>{translations[language].contactUs}</h1>
      <form className="contact-form" onSubmit={handleSubmit}>
        <div className="form-group">
          <label htmlFor="name">{translations[language].name}:</label>
          <input type="text" id="name" name="name" value={formData.name} onChange={handleInputChange} required />
        </div>
        <div className="form-group">
          <label htmlFor="email">{translations[language].email}:</label>
          <input type="email" id="email" name="email" value={formData.email} onChange={handleInputChange} required />
        </div>
        <div className="form-group">
          <label htmlFor="message">{translations[language].message}:</label>
          <textarea id="message" name="message" rows="5" value={formData.message} onChange={handleInputChange} required></textarea>
        </div>
        <div className="form-group">
          <label htmlFor="file">{translations[language].uploadFile}:</label>
          <input type="file" id="file" name="file" onChange={handleFileChange} />
        </div>
        <button type="submit" className="submit-button">{translations[language].send}</button>
      </form>
    </div>
  );
};

export default Contact;
