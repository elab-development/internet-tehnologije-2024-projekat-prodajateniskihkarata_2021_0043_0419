// src/components/PaymentModal.test.jsx
import { render } from '@testing-library/react';
import { UserProvider } from '../contexts/UserContext';  
import { LanguageProvider } from '../contexts/LanguageContext'; 
import PaymentModal from './PaymentModal'; 

test('PaymentModal Component renders without crashing', () => {
  render(
    <UserProvider>
      <LanguageProvider>
        <PaymentModal />
      </LanguageProvider>
    </UserProvider>
  );
});
