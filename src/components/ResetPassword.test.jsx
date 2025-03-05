import { render } from '@testing-library/react';
import { LanguageProvider } from '../contexts/LanguageContext'; 
import { BrowserRouter } from 'react-router-dom';
import ResetPassword from '../components/ResetPassword';  

test('ResetPassword Component renders without crashing', () => {
  render(
    <LanguageProvider>
      <BrowserRouter>
        <ResetPassword />
      </BrowserRouter>
    </LanguageProvider>
  );
});
