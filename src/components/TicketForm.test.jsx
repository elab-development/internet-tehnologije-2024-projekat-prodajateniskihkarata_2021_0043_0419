
import { render } from '@testing-library/react';
import TicketForm from './TicketForm'; 

test('TicketForm Component renders without crashing', () => {
  const ticket = { price: 10 }; 
  render(<TicketForm ticket={ticket} />);
});
