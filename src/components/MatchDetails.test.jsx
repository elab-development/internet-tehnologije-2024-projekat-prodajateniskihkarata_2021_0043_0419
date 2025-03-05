import { render } from '@testing-library/react';
import MatchDetails from './MatchDetails';

describe('MatchDetails Component', () => {
  it('renders without crashing', () => {
    const { container } = render(<MatchDetails />);
    expect(container).toBeInTheDocument();
  });
});
