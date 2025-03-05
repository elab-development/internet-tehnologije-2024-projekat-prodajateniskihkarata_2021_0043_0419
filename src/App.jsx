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
import ForgotPassword from './components/ForgotPassword';
import ResetPassword from './components/ResetPassword';
import ChangePassword from './components/ChangePassword';
import { UserProvider } from './contexts/UserContext';
import Users from './components/Users';
import UsersEdit from './components/UsersEdit';
import AdminUsers from './components/AdminUsers';
import MatchEdit from './components/MatchEdit';
import Payments from "./components/Payments";
import { LanguageProvider } from './contexts/LanguageContext';
import LanguageSwitcher from './components/LanguageSwitcher';


//import WeatherMap from "./components/WeatherMap";

import './App.css';

function App() {
    return (
        <UserProvider>
            <LanguageProvider>
            <Router>
                <BreadcrumbsProvider>
                    <div className="app-container">
                        <NavBar />
                        <LanguageSwitcher /> {/* Dodajemo izbor jezika u gornji levi ugao */}
                        <BreadcrumbsComponent />
                        <div className="content">
                            <Routes>
                                <Route path="/" element={<Home />} />
                                <Route path="/matches" element={<Matches />} />
                                <Route path="/matches/:id" element={<MatchDetails />} /> {/* Ruta za detalje */}
                                <Route path="/matches/edit/:id" element={<MatchEdit />} />
                                <Route path="/buy-ticket" element={<BuyTicket />} />
                                <Route path="/login" element={<Login />} />
                                <Route path="/register" element={<Register />} />
                                <Route path="/contact" element={<Contact />} />
                                <Route path="/forgot-password" element={<ForgotPassword />} />
                                <Route path="/reset-password" element={<ResetPassword />} />
                                <Route path="/change-password" element={<ChangePassword />} />
                                <Route path="/users" element={<Users />} />
                                <Route path="/users/edit/:id" element={<UsersEdit />} />
                                <Route path="/admin-users" element={<AdminUsers />} />
                                <Route path="/payments" element={<Payments />} />
                                {/* <Route path="/weather-map" element={<WeatherMap />} /> */}
                            </Routes>
                        </div>
                        <Footer />
                    </div>
                </BreadcrumbsProvider>
            </Router>
            </LanguageProvider>
        </UserProvider>
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