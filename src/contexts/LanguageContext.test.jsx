import { render } from '@testing-library/react';
import { LanguageProvider } from '../contexts/LanguageContext.jsx';

test('LanguageContext Provider renders without crashing', () => {
  render(
    <LanguageProvider>
      <div>Test</div>
    </LanguageProvider>
  );
});
