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

  const translateLabel = (label) => {
    if (label === 'pagination.previous') return '« Anterior';
    if (label === 'pagination.next') return 'Siguiente »';
    return label;
  };

  return (
    <div className="d-flex justify-content-center py-2">
      <ul className="pagination mb-0">
        {pagination.links.map((link, index) => {
          const label = translateLabel(link.label);
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
                className="page-link"
              >
                {label}
              </a>
            </li>
          );
        })}
      </ul>
    </div>
  );
};

export default CPagination;

