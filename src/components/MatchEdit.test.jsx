import { render } from '@testing-library/react';
import { UserProvider } from '../contexts/UserContext';  
import { BrowserRouter } from 'react-router-dom';
import MatchEdit from '../components/MatchEdit';  
test('MatchEdit Component renders without crashing', () => {
  render(
    <UserProvider>
      <BrowserRouter>
        <MatchEdit />
      </BrowserRouter>
    </UserProvider>
  );
});
