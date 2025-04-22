import { h, render } from 'preact';
import Lista from './components/perfil-institucional/institucion/autoevaluacion/Lista.jsx';
import Crear from './components/perfil-institucional/institucion/autoevaluacion/Crear.jsx';
import Editar from "./components/perfil-institucional/institucion/autoevaluacion/Editar.jsx";
import Ver from "./components/perfil-institucional/institucion/autoevaluacion/Ver.jsx";


// Mapea los nombres a los componentes importados
const components = {
    Lista,
    Crear,
    Editar,
    Ver
};

// Encuentra todos los elementos que tienen `data-component`
document.querySelectorAll('[data-component]').forEach((el) => {
    const componentName = el.getAttribute('data-component');
    const Component = components[componentName];

    if (Component) {
        // Recolecta todos los atributos personalizados como props
        const props = {};
        for (let attr of el.attributes) {
            if (attr.name.startsWith('data-') && attr.name !== 'data-component') {
                const propName = attr.name
                    .replace('data-', '')
                    .replace(/-([a-z])/g, (g) => g[1].toUpperCase());
                try {
                    props[propName] = JSON.parse(attr.value);
                } catch (e) {
                    props[propName] = attr.value;
                }
            }
        }

        render(<Component {...props} />, el);
    }
});
