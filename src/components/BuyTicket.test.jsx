import { render } from '@testing-library/react';
import BuyTicket from './BuyTicket';

describe('BuyTicket Component', () => {
  it('renders without crashing', () => {
    const { container } = render(<BuyTicket />);
    expect(container).toBeInTheDocument();
  });
});
