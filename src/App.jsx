import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
import { BreadcrumbsProvider } from 'react-breadcrumbs-dynamic';
import Home from './components/Home';
import Matches from './components/Matches';
import MatchDetails from './components/MatchDetails'; // Dodata stranica za detalje
import BuyTicket from './components/BuyTicket';
import Login from './components/Login';
import Register from './components/Register';
import Contact from './components/Contact';
import NavBar from './components/NavBar';
import Footer from './components/Footer';
import BreadcrumbsComponent from './components/Breadcrumbs';

import './App.css';

function App() {
    return (
        <Router>
            <BreadcrumbsProvider>
                <div className="app-container">
                    <NavBar />
                    <BreadcrumbsComponent />
                    <div className="content">
                        <Routes>
                            <Route path="/" element={<Home />} />
                            <Route path="/matches" element={<Matches />} />
                            <Route path="/matches/:id" element={<MatchDetails />} /> {/* Ruta za detalje */}
                            <Route path="/buy-ticket" element={<BuyTicket />} />
                            <Route path="/login" element={<Login />} />
                            <Route path="/register" element={<Register />} />
                            <Route path="/contact" element={<Contact />} />
                        </Routes>
                    </div>
                    <Footer />
                </div>
            </BreadcrumbsProvider>
        </Router>
    );
}

export default App;


// import React from 'react';
// import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';
// import Home from './components/Home';
// import Matches from './components/Matches';
// import BuyTicket from './components/BuyTicket';
// import Login from './components/Login';
// import Register from './components/Register';
// import Contact from './components/Contact';
// import NavBar from './components/NavBar';
// import Footer from './components/Footer';

// import './App.css'; // Import CSS for general styling

// function App() {
//     return (
//         <Router>
//             <div className="app-container">
//                 <NavBar />
//                 <div className="content">
//                     <Routes>
//                         <Route path="/" element={<Home />} />
//                         <Route path="/matches" element={<Matches />} />
//                         <Route path="/buy-ticket" element={<BuyTicket />} />
//                         <Route path="/login" element={<Login />} />
//                         <Route path="/register" element={<Register />} />
//                         <Route path="/contact" element={<Contact />} />
//                     </Routes>
//                 </div>
//                 <Footer />
//             </div>
//         </Router>
//     );
// }

// export default App;