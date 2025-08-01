// src/ui/CNavigationButton.jsx
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
 * @param {string} [props.target] - Atributo target para enlaces (ej: '_blank' para nueva pestaña) // Se añadió la nueva prop 'target'
 * @returns {JSX.Element} Componente de botón
 */
const CNavigationButton = ({
  to = -1,
  label = 'Volver',
  isContainer = false,
  className = '',
  variant = 'outline-primary',
  icon = 'fa-arrow-left',
  size = '',
  disabled = false,
  onClick,
  target // Se desestructuró la nueva prop
}) => {
  const handleClick = (e) => {
    if (onClick) {
      onClick(e);
      if (e.defaultPrevented) return;
    }

    if (disabled) return;

    // Solo para botones que no son enlaces con target
    if (!target) { // Se añadió una condición para no ejecutar esto si es un enlace con target
      if (typeof to === 'number') {
        window.history.go(to);
      } else {
        // Para navegación interna o si no se usa target
        // Si 'to' es una URL, location.href sigue siendo la forma predeterminada
        // para la navegación sin target
        if (to && typeof to === 'string' && to !== '#') {
          window.location.href = to;
        }
      }
    }
  };

  const buttonClasses = [
    'btn',
    `btn-${variant}`,
    size ? `btn-${size}` : '',
    'd-flex align-items-center gap-2',
    className
  ].filter(Boolean).join(' ');

  // Se añadió lógica condicional para renderizar un <a> o un <button>
  const buttonElement = target && typeof to === 'string' && to !== '#' ? (
    <a
      href={to}
      target={target}
      className={buttonClasses}
      onClick={onClick} // Mantener el onClick para posibles acciones antes de la navegación del enlace
      disabled={disabled} // Disabled para <a> a través de CSS o lógica
      aria-label={label}
      role="button" // Para accesibilidad, ya que un <a> se está usando como botón
    >
      {icon && <i className={`fa ${icon}`} aria-hidden="true"></i>}
      {label}
    </a>
  ) : (
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

export default CNavigationButton;