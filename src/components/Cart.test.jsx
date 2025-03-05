import { render } from '@testing-library/react';
import { UserProvider } from '../contexts/UserContext.jsx';
import { LanguageProvider } from '../contexts/LanguageContext.jsx';
import Cart from '../components/Cart.jsx';

test('Cart Component renders without crashing', () => {
  render(
    <UserProvider>
      <LanguageProvider>
        <Cart cart={[]} setCart={() => {}} setShowCart={() => {}} onConfirmPurchase={() => {}} />
      </LanguageProvider>
    </UserProvider>
  );
});
