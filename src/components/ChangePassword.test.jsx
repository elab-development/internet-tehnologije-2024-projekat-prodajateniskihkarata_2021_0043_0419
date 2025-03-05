// import { render, screen } from '@testing-library/react';
// import { LanguageContext } from '../contexts/LanguageContext'; // Uverite se da je LanguageContext pravilno importovan
// import ChangePassword from './ChangePassword';

// test('ChangePassword Component renders without crashing', () => {
//   const mockLanguage = 'en'; // Mock language objekat

//   render(
//     <LanguageContext.Provider value={{ language: mockLanguage }}>
//       <ChangePassword />
//     </LanguageContext.Provider>
//   );

//   // Dodajte aserciju da proverite da li se komponenta pravilno renderuje
//   expect(screen.getByText('Change Password')).toBeInTheDocument();
// });

import { render } from '@testing-library/react';
import { UserProvider } from '../contexts/UserContext'; 
import { LanguageProvider } from '../contexts/LanguageContext';
import { BrowserRouter } from 'react-router-dom'; 
import ChangePassword from './ChangePassword';

test('ChangePassword Component renders without crashing', () => {
  render(
    <UserProvider>
      <LanguageProvider>
        <BrowserRouter> {}
          <ChangePassword />
        </BrowserRouter>
      </LanguageProvider>
    </UserProvider>
  );
});
