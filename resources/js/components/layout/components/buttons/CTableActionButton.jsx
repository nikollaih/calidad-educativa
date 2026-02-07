// src/ui/CTableActionButton.jsx
import { h } from 'preact';
import CTooltip from "@/components/shared/CTooltip.jsx";

const CTableActionButton = ({
                         route = undefined,
                         onClick = null,
                         formRef = null,
                         confirmMessage = null,
                         iconClass = '',
                         hoverIconColor = '',
                         title = ''
                     }) => {
    const handleClick = (e) => {
        e.preventDefault(); // Prevenir comportamiento por defecto del enlace
        // Si hay mensaje de confirmación, mostrarlo primero
        if (confirmMessage) {
            if (!confirm(confirmMessage)) {
                return; // Cancelar la acción si el usuario cancela
            }
        }

        if (route !== undefined) {
            console.log('ejecutando route', route);
            window.location.href = route;
            return;
        }

        if (formRef) {
            const form = document.querySelector(formRef);
            if (form) {
                form.submit();
            }
            return;
        }

        if (onClick) {
            onClick(e);
        }
    };

    return (
        <CTooltip label={title}>
            <a onClick={handleClick} className="inline-block">
                <i
                    className={`${iconClass} hover:${hoverIconColor} text-gray-500 cursor-pointer text-xl hover:border hover:rounded-md p-2 hover:border-custom-blue-dark hover:bg-gray-100`}
                    aria-hidden="true">
                </i>
            </a>
        </CTooltip>
    );
};

export default CTableActionButton;
