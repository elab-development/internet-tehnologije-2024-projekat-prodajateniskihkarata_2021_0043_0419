import React from 'react';

const Contact = () => {
    return (
        <div>
            <h1>Contact Us</h1>
            <form>
                <div>
                    <label>Name:</label>
                    <input type="text" name="name" required />
                </div>
                <div>
                    <label>Email:</label>
                    <input type="email" name="email" required />
                </div>
                <div>
                    <label>Message:</label>
                    <textarea name="message" rows="5" required></textarea>
                </div>
                <button type="submit">Send</button>
            </form>
        </div>
    );
};

export default Contact;