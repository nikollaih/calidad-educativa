
import { h, render } from 'preact';
import Lista from './components/perfil-institucional/institucion/autoevaluacion/Lista.jsx';
import Crear from './components/perfil-institucional/institucion/autoevaluacion/Crear.jsx';


const root = document.getElementById('autoevaluacion');
const crearAutoevaluacion = document.getElementById('autoevaluacion-crear');

if (root) {
    render(<Lista />, root);
}
if(crearAutoevaluacion){
    render(<Crear />, crearAutoevaluacion);
}
