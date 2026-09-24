// src/ui/CPagination.jsx
import { h } from 'preact';

/**
 * Componente de Paginación para Laravel Monolito (Bootstrap)
 *
 * @param {Object} props
 * @param {Object} props.pagination - Objeto de paginación de Laravel
 * @returns {JSX.Element}
 */
const CPagination = ({ pagination }) => {
    if (!pagination || !pagination.links) return null;

    const renderLabel = (label) => {
        // Icono para "Anterior"
        if (label === 'pagination.previous' || label.includes('Previous') || label.includes('Anterior')) {
            return <i className="fa-solid fa-caret-left"></i>;
        }

        // Icono para "Siguiente"
        if (label === 'pagination.next' || label.includes('Next') || label.includes('Siguiente')) {
            return <i className="fa-solid fa-caret-right hover:text-custom-primary"></i>;
        }

        // Números de página normales
        return label.replace(/&laquo;|&raquo;/g, '').trim();
    };

    return (
        <div className="d-flex justify-content-center py-2">
            <ul className="pagination mb-0">
                {pagination.links.map((link, index) => {
                    const isActive = link.active;
                    const isDisabled = !link.url;

                    return (
                        <li
                            key={index}
                            className={`page-item ${isActive ? 'active' : ''} ${
                                isDisabled ? 'disabled' : ''
                            }`}
                        >
                            <a
                            href={link.url || '#'}
                            className="p-2 rounded-full"
                            aria-label={link.label}
                            >
                            {renderLabel(link.label)}
                        </a>
                </li>
                );
                })}
            </ul>
        </div>
    );
};

export default CPagination;
