import React, { useState } from 'react';
import axios from 'axios';
// import './Contact.css';

const Contact = () => {
  const [file, setFile] = useState(null);
  const [formData, setFormData] = useState({
    name: '',
    email: '',
    message: ''
  });

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
      alert('File and form data uploaded successfully');
    } catch (error) {
      console.error('Error uploading file and form data:', error);
      alert('Failed to upload file and form data');
    }
  };

  return (
    <div className="contact-container">
      <h1>Contact Us</h1>
      <form className="contact-form" onSubmit={handleSubmit}>
        <div className="form-group">
          <label htmlFor="name">Name:</label>
          <input type="text" id="name" name="name" value={formData.name} onChange={handleInputChange} required />
        </div>
        <div className="form-group">
          <label htmlFor="email">Email:</label>
          <input type="email" id="email" name="email" value={formData.email} onChange={handleInputChange} required />
        </div>
        <div className="form-group">
          <label htmlFor="message">Message:</label>
          <textarea id="message" name="message" rows="5" value={formData.message} onChange={handleInputChange} required></textarea>
        </div>
        <div className="form-group">
          <label htmlFor="file">Upload File:</label>
          <input type="file" id="file" name="file" onChange={handleFileChange} />
        </div>
        <button type="submit" className="submit-button">Send</button>
      </form>
    </div>
  );
};

export default Contact;