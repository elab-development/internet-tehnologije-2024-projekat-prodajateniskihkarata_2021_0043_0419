// src/components/TicketList.test.jsx
import { render } from '@testing-library/react';
import TicketList from './TicketList'; 

test('TicketList Component renders without crashing', () => {
  const tickets = [
    { id: 1, name: 'Ticket 1' },
    { id: 2, name: 'Ticket 2' }
  ];
  
  render(<TicketList tickets={tickets} />);
});
