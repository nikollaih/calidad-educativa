// src/ui/CAddButton.jsx
import { h } from 'preact';

const CAddButton = ({
                         route = undefined,
                         onClick = null,
                     }) => {
    const handleClick = (e) => {
        if (route !== undefined) {
            console.log('ejecutando route', route);
            window.location.href = route;
            return;
        }
        if (onClick) {
            e.preventDefault();
            onClick(e);
        }
    };

    return (
        <a
            href={route !== null ? route : '#'}
            onClick={handleClick}
            className="inline-flex items-center mb-3 group cursor-pointer !border border-custom-blue-light overflow-hidden transition-all duration-300 rounded-full hover:no-underline"
            style="border-radius: 9999px;">
            {/* Icono visible siempre */}
            <div className="flex items-center justify-center w-10 h-10 flex-shrink-0 transition-all duration-300">
                <i className="fa fa-plus text-custom-blue-light text-xl" aria-hidden="true"></i>
            </div>

            {/* Texto que aparece en hover */}
            <span className="inline-block py-2 text-custom-blue-light font-medium whitespace-nowrap
                                  w-0 opacity-0 overflow-hidden px-0
                                  group-hover:w-32 group-hover:opacity-100 group-hover:px-4
                                  transition-all duration-300 ease-out">
                Agregar
            </span>
        </a>
    );
};

export default CAddButton;
