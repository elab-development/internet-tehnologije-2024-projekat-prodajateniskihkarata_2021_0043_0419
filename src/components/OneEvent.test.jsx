// import { render, screen } from '@testing-library/react';
// import { UserContext } from '../contexts/UserContext'; // Importujte UserContext
// import { LanguageContext } from '../contexts/LanguageContext'; // Importujte LanguageContext
// import OneEvent from './OneEvent';

// test('OneEvent Component renders without crashing', () => {
//   const mockUser = { uloga: 'admin' }; // Mock korisnika
//   const mockLanguage = 'en'; // Mock jezika
//   const dogadjaj = {}; // Mock događaja

//   render(
//     <UserContext.Provider value={{ user: mockUser }}>
//       <LanguageContext.Provider value={{ language: mockLanguage }}>
//         <OneEvent dogadjaj={dogadjaj} isAdmin={true} />
//       </LanguageContext.Provider>
//     </UserContext.Provider>
//   );

//   // Dodajte aserciju da proverite da li se komponenta pravilno renderuje
//   expect(screen.getByText('Event Details')).toBeInTheDocument();
// });

import { render } from '@testing-library/react';
import { LanguageProvider } from '../contexts/LanguageContext';  
import { UserProvider } from '../contexts/UserContext';  
import { BrowserRouter } from 'react-router-dom';
import OneEvent from '../components/OneEvent';

test('OneEvent Component renders without crashing', () => {
  render(
    <UserProvider>
      <LanguageProvider>
        <BrowserRouter>
          <OneEvent dogadjaj={{}} isAdmin={false} />
        </BrowserRouter>
      </LanguageProvider>
    </UserProvider>
  );
});


