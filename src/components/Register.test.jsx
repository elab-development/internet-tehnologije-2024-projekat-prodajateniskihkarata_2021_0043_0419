// import { render } from '@testing-library/react';
// import { BrowserRouter } from 'react-router-dom';
// import Payments from '../components/Payments.jsx';

// test('Payments Component renders without crashing', () => {
//   render(
//     <BrowserRouter>
//       <Payments />
//     </BrowserRouter>
//   );
// });

import { render } from '@testing-library/react';
import { BrowserRouter } from 'react-router-dom';
import { LanguageProvider } from '../contexts/LanguageContext.jsx';
import Register from '../components/Register.jsx';

test('Register Component renders without crashing', () => {
  render(
    <BrowserRouter>
      <LanguageProvider>
        <Register />
      </LanguageProvider>
    </BrowserRouter>
  );
});
