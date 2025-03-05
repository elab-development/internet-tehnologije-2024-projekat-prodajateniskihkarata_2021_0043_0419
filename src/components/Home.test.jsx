// src/components/Home.test.jsx
import { render } from '@testing-library/react';
import { LanguageProvider } from '../contexts/LanguageContext'; 
import Home from './Home'; 

test('Home Component renders without crashing', () => {
  render(
    <LanguageProvider>
      <Home />
    </LanguageProvider>
  );
});
