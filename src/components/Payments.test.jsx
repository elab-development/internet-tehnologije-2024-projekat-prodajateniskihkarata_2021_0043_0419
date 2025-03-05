// import { render, screen } from '@testing-library/react';
// import { UserContext } from '../contexts/UserContext'; // Uverite se da je UserContext pravilno importovan
// import Payments from './Payments';

// test('Payments Component renders without crashing', () => {
//   const mockUser = { uloga: 'admin' }; // Mock user objekat

//   render(
//     <UserContext.Provider value={{ user: mockUser }}>
//       <Payments />
//     </UserContext.Provider>
//   );

//   // Dodajte aserciju da proverite da li se komponenta pravilno renderuje
//   expect(screen.getByText('Payments')).toBeInTheDocument();
// });


import { render } from '@testing-library/react';
import { MemoryRouter } from 'react-router-dom'; 
import { UserProvider } from '../contexts/UserContext'; 
import { LanguageProvider } from '../contexts/LanguageContext'; 
import Payments from './Payments'; 

test('Payments Component renders without crashing', () => {
  render(
    <MemoryRouter>
      <UserProvider>
        <LanguageProvider>
          <Payments />
        </LanguageProvider>
      </UserProvider>
    </MemoryRouter>
  );
});
