// src/components/LanguageSwitcher.test.jsx
import { render } from '@testing-library/react';
import { LanguageProvider } from '../contexts/LanguageContext'; 
import LanguageSwitcher from './LanguageSwitcher'; 

test('LanguageSwitcher Component renders without crashing', () => {
  render(
    <LanguageProvider>
      <LanguageSwitcher />
    </LanguageProvider>
  );
});
