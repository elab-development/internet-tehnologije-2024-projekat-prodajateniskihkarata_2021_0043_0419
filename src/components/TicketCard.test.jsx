import { render } from '@testing-library/react';
import TicketCard from './TicketCard';

describe('TicketCard Component', () => {
  it('renders without crashing', () => {
    const { container } = render(<TicketCard />);
    expect(container).toBeInTheDocument();
  });
});
