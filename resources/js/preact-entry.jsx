
import { h, render } from 'preact';
import Hello from './components/Hello.jsx';

const root = document.getElementById('autoevaluacion');
if (root) {
    render(<Hello />, root);
}
