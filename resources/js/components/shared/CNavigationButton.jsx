// src/ui/CBackButton.jsx
import { h } from 'preact';

/**
 * Componente de botón de navegación optimizado para grupos
 * 
 * @param {Object} props - Propiedades del componente
 * @param {string|number} props.to - URL o valor para history.go()
 * @param {string} [props.label='Acción'] - Texto del botón
 * @param {boolean} [props.isContainer=false] - Envuelve en contenedor
 * @param {string} [props.className=''] - Clases CSS adicionales
 * @param {string} [props.variant='outline-primary'] - Variante de Bootstrap
 * @param {string} [props.icon='fa-arrow-right'] - Icono de FontAwesome
 * @param {string} [props.size=''] - Tamaño (sm, lg)
 * @param {boolean} [props.disabled=false] - Estado deshabilitado
 * @param {function} [props.onClick] - Handler de click adicional
 * @returns {JSX.Element} Componente de botón
 */
const CBackButton = ({
  to = -1,
  label = 'Volver',
  isContainer = false,
  className = '',
  variant = 'outline-primary',
  icon = 'fa-arrow-left',
  size = '',
  disabled = false,
  onClick
}) => {
  const handleClick = (e) => {
    if (onClick) {
      onClick(e);
      if (e.defaultPrevented) return;
    }

    if (disabled) return;

    if (typeof to === 'number') {
      window.history.go(to);
    } else {
      window.location.href = to;
    }
  };

  const buttonClasses = [
    'btn',
    `btn-${variant}`,
    size ? `btn-${size}` : '',
    'd-flex align-items-center gap-2',
    className
  ].filter(Boolean).join(' ');

  const buttonElement = (
    <button
      type="button"
      className={buttonClasses}
      onClick={handleClick}
      disabled={disabled}
      aria-label={label}
    >
      {icon && <i className={`fa ${icon}`} aria-hidden="true"></i>}
      {label}
    </button>
  );

  if (isContainer) {
    return <div className="container">{buttonElement}</div>;
  }

  return buttonElement;
};

export default CBackButton;