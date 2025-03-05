// import { render, screen } from '@testing-library/react';
// import { UserContext } from '../contexts/UserContext'; // Importujte UserContext
// import { LanguageContext } from '../contexts/LanguageContext'; // Importujte LanguageContext
// import Contact from './Contact';

// test('Contact Component renders without crashing', () => {
//   const mockUser = { uloga: 'admin' }; // Mock korisnika
//   const mockLanguage = 'en'; // Mock jezika

//   render(
//     <UserContext.Provider value={{ user: mockUser }}>
//       <LanguageContext.Provider value={{ language: mockLanguage }}>
//         <Contact />
//       </LanguageContext.Provider>
//     </UserContext.Provider>
//   );

//   // Dodajte aserciju da proverite da li se komponenta pravilno renderuje
//   expect(screen.getByText('Contact')).toBeInTheDocument();
// });

import { render } from '@testing-library/react';
import { UserProvider } from '../contexts/UserContext.jsx';
import { LanguageProvider } from '../contexts/LanguageContext.jsx';
import Contact from '../components/Contact.jsx';

test('Contact Component renders without crashing', () => {
  render(
    <UserProvider>
      <LanguageProvider>
        <Contact />
      </LanguageProvider>
    </UserProvider>
  );
});


