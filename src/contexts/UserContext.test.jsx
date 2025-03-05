import { render, screen } from '@testing-library/react';
import { UserContext } from './UserContext'; 

test('renders UserContext provider', () => {
  render(
    <UserContext.Provider value={{ user: { name: 'Test User' } }}>
      <div>Test User Context</div>
    </UserContext.Provider>
  );
  expect(screen.getByText('Test User Context')).toBeInTheDocument();
});
