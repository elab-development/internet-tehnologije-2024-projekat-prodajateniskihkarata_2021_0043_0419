import { render } from '@testing-library/react';
import { UserProvider } from '../contexts/UserContext'; 
import { LanguageProvider } from '../contexts/LanguageContext'; 
import { BrowserRouter } from 'react-router-dom'; 
import Users from './Users';

test('Users Component renders without crashing', () => {
  render(
    <UserProvider>
      <LanguageProvider>
        <BrowserRouter> {}
          <Users />
        </BrowserRouter>
      </LanguageProvider>
    </UserProvider>
  );
});
