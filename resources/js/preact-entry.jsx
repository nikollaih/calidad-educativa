import { h, render } from 'preact';

/**
 * Importa todos los componentes JSX de forma óptima utilizando import.meta.glob
 * @returns {Promise<Object>} Un objeto con todos los componentes indexados por nombre
 */
async function importAllComponents() {
    // Importación dinámica con modo eager para mejor rendimiento
    const componentModules = import.meta.glob('./components/**/*.jsx', { eager: true });
    const components = {};

    // Procesamos cada módulo sin necesidad de awaits en bucle
    Object.entries(componentModules).forEach(([path, module]) => {
        // Extraemos el nombre del componente del path
        const componentName = path.split('/').pop().replace(/\.jsx$/, '');

        // Guardamos el componente por defecto o el primer export nombrado si existe
        if (module.default) {
            components[componentName] = module.default;
        } else {
            // Buscar el primer export nombrado como fallback
            const namedExport = Object.keys(module).find(key => key !== '__esModule');
            if (namedExport) {
                components[componentName] = module[namedExport];
            }
        }
    });

    return components;
}

/**
 * Convierte atributos de data-* a props para el componente
 * @param {HTMLElement} element - Elemento DOM con atributos data-*
 * @returns {Object} - Objeto de props procesado
 */
function extractPropsFromElement(element) {
    const props = {};

    Array.from(element.attributes).forEach(attr => {
        if (attr.name.startsWith('data-') && attr.name !== 'data-component') {
            // Convertimos data-prop-name a propName (camelCase)
            const propName = attr.name
                .replace('data-', '')
                .replace(/-([a-z])/g, (_, letter) => letter.toUpperCase());

            // Intentamos parsear JSON, si falla usamos el valor tal cual
            try {
                // Detectamos arrays y objetos
                const value = attr.value.trim();
                if ((value.startsWith('{') && value.endsWith('}')) ||
                    (value.startsWith('[') && value.endsWith(']'))) {
                    props[propName] = JSON.parse(value);
                } else if (value === 'true') {
                    props[propName] = true;
                } else if (value === 'false') {
                    props[propName] = false;
                } else if (!isNaN(Number(value)) && value !== '') {
                    props[propName] = Number(value);
                } else {
                    props[propName] = value;
                }
            } catch (e) {
                props[propName] = attr.value;
            }
        }
    });

    return props;
}

/**
 * Inicializa los componentes en el DOM
 */
async function initComponents() {
    // Cache de componentes para no tener que importarlos múltiples veces
    const componentsCache = await importAllComponents();

    // Encuentra todos los elementos con data-component
    const componentElements = document.querySelectorAll('[data-component]');

    // Procesamos cada elemento encontrado
    componentElements.forEach(el => {
        const componentName = el.getAttribute('data-component');
        const Component = componentsCache[componentName];

        if (Component) {
            const props = extractPropsFromElement(el);

            // Preservar el contenido interno como children si existe
            if (el.childNodes.length > 0) {
                const children = Array.from(el.childNodes);
                props.children = children;
            }

            render(<Component {...props} />, el);
        } else {
            console.warn(`Componente "${componentName}" no encontrado en la biblioteca de componentes`);
        }
    });
}

// Inicializar cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initComponents);
} else {
    initComponents();
}

// Exportamos la función por si necesitamos inicializar componentes después de cambios en el DOM
export { initComponents };
