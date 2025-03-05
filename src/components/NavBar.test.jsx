// import { render } from '@testing-library/react';
// import NavBar from './NavBar';

// describe('NavBar Component', () => {
//   it('renders without crashing', () => {
//     const { container } = render(<NavBar />);
//     expect(container).toBeInTheDocument();
//   });
// });

import { render } from '@testing-library/react';
import { UserProvider } from '../contexts/UserContext'; 
import { LanguageProvider } from '../contexts/LanguageContext'; 
import { BrowserRouter } from 'react-router-dom';
import NavBar from './NavBar';

test('NavBar Component renders without crashing', () => {
  render(
    <UserProvider>
      <LanguageProvider>
        <BrowserRouter>
          <NavBar />
        </BrowserRouter>
      </LanguageProvider>
    </UserProvider>
  );
});

