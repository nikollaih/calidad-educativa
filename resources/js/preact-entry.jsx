
import { h, render } from 'preact';
import Hello from './components/Hello.jsx';
import Crear from './components/perfil-institucional/institucion/autoevaluacion/Crear.jsx';


const root = document.getElementById('autoevaluacion');
const crearAutoevaluacion = document.getElementById('autoevaluacion-crear');

if (root) {
    render(<Hello />, root);
}
if(crearAutoevaluacion){
    render(<Crear />, crearAutoevaluacion);
}
