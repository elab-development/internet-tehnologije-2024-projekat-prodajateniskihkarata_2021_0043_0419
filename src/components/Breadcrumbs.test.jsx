import { render } from '@testing-library/react';
import { MemoryRouter } from 'react-router-dom'; 
import Breadcrumbs from '../components/Breadcrumbs.jsx';

test('Breadcrumbs Component renders without crashing', () => {
  render(
    <MemoryRouter>
      <Breadcrumbs />
    </MemoryRouter>
  );
});
