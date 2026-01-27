// src/ui/CTableActionButton.jsx
import { h } from 'preact';

const CTableActionButton = ({
                         route = undefined,
                         onClick = null,
                         iconClass = '',
                         hoverIconColor = '',
                         title = ''
                     }) => {
    const handleClick = (e) => {
        e.preventDefault(); // Prevenir comportamiento por defecto del enlace

        if (route !== undefined) {
            console.log('ejecutando route', route);
            window.location.href = route;
            return;
        }

        if (onClick) {
            onClick(e);
        }
    };

    return (
        <a onClick={handleClick} className="inline-block">
            <i
                className={`${iconClass} hover:${hoverIconColor} text-gray-500 cursor-pointer text-xl hover:border hover:rounded-md p-2 hover:border-custom-blue-dark hover:bg-gray-100`}
                aria-hidden="true">
            </i>
        </a>
    );
};

export default CTableActionButton;
