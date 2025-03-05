import { render } from '@testing-library/react';
import { LanguageProvider } from '../contexts/LanguageContext.jsx';
import ForgotPassword from '../components/ForgotPassword.jsx';

test('ForgotPassword Component renders without crashing', () => {
  render(
    <LanguageProvider>
      <ForgotPassword />
    </LanguageProvider>
  );
});
