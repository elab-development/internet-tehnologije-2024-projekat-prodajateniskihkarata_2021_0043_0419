// import { render } from '@testing-library/react';
// import { UserProvider } from '../contexts/UserContext.jsx';
// import Login from '../components/Login.jsx';

// test('Login Component renders without crashing', () => {
//   render(
//     <UserProvider>
//       <Login />
//     </UserProvider>
//   );
// });


// import { render, screen } from '@testing-library/react';
// import { BrowserRouter } from 'react-router-dom'; // Dodajte BrowserRouter
// import Login from './Login'; // Importujte vašu Login komponentu

// test('Login Component renders without crashing', () => {
//   render(
//     <BrowserRouter>
//       <Login />
//     </BrowserRouter>
//   );
//   // Dodajte asertacije za testiranje komponenta
// });

import { render } from '@testing-library/react';
import { UserProvider } from '../contexts/UserContext';  
import { LanguageProvider } from '../contexts/LanguageContext';  
import { BrowserRouter } from 'react-router-dom';
import Login from '../components/Login';  

test('Login Component renders without crashing', () => {
  render(
    <UserProvider>
      <LanguageProvider>
        <BrowserRouter>
          <Login />
        </BrowserRouter>
      </LanguageProvider>
    </UserProvider>
  );
});
