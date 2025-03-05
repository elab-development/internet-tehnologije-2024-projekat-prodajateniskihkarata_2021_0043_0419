// import { render } from '@testing-library/react';
// import { UserProvider } from '../contexts/UserContext.jsx';
// import AdminUsers from '../components/AdminUsers.jsx';

// test('AdminUsers Component renders without crashing', () => {
//   render(
//     <UserProvider>
//       <AdminUsers />
//     </UserProvider>
//   );
// });


import { render } from '@testing-library/react';
import { LanguageProvider } from '../contexts/LanguageContext'; 
import { UserProvider } from '../contexts/UserContext';
import { BrowserRouter } from 'react-router-dom';
import AdminUsers from '../components/AdminUsers'; 

test('AdminUsers Component renders without crashing', () => {
  render(
    <UserProvider>
      <LanguageProvider>
        <BrowserRouter>
          <AdminUsers />
        </BrowserRouter>
      </LanguageProvider>
    </UserProvider>
  );
});
