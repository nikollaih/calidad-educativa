
import { h, render } from 'preact';
import Lista from './components/perfil-institucional/institucion/autoevaluacion/Lista.jsx';
import Crear from './components/perfil-institucional/institucion/autoevaluacion/Crear.jsx';
import VerGestionComunidad from './components/perfil-institucional/institucion/pei/VerGestionComunidad.jsx';


const root = document.getElementById('autoevaluacion');
const crearAutoevaluacion = document.getElementById('autoevaluacion-crear');
const gestionComunidad = document.getElementById('ver-gestion-comunidad-crear');

if (root) {
    render(<Lista />, root);
}
if(crearAutoevaluacion){
    render(<Crear />, crearAutoevaluacion);
}
if(gestionComunidad){
    render(<VerGestionComunidad />, gestionComunidad);
}
