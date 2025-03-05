// import { render } from '@testing-library/react';
// import Matches from './Matches';

// describe('Matches Component', () => {
//   it('renders without crashing', () => {
//     const { container } = render(<Matches />);
//     expect(container).toBeInTheDocument();
//   });
// });

import { render } from '@testing-library/react';
import { UserProvider } from '../contexts/UserContext';  
import { LanguageProvider } from '../contexts/LanguageContext';  
import { BrowserRouter } from 'react-router-dom';
import Matches from '../components/Matches';  

test('Matches Component renders without crashing', () => {
  render(
    <UserProvider>
      <LanguageProvider>
        <BrowserRouter>
          <Matches />
        </BrowserRouter>
      </LanguageProvider>
    </UserProvider>
  );
});
