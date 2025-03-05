import { render } from '@testing-library/react';
import { MemoryRouter } from 'react-router-dom'; 
import { UserProvider } from '../contexts/UserContext.jsx'; 
import { LanguageProvider } from '../contexts/LanguageContext.jsx'; 
import UsersEdit from '../components/UsersEdit.jsx'; 

test('UsersEdit Component renders without crashing', () => {
  render(
    <MemoryRouter> {}
      <UserProvider> {}
        <LanguageProvider> {}
          <UsersEdit />
        </LanguageProvider>
      </UserProvider>
    </MemoryRouter>
  );
});
