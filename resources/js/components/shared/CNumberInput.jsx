import { h } from 'preact';

/**
 * Componente CNumberInput
 *
 * Es un input de texto personalizado para el ingreso de números
 * que permite controlar:
 *  - El tipo de número (entero o decimal).
 *  - El rango de valores permitidos (positivo, negativo, mixto, positivo_sin_cero).
 *
 * Props:
 *  - name: Nombre del campo (atributo name del input).
 *  - value: Valor inicial/controlado del input.
 *  - tipo: Define si el número debe ser:
 *      - "entero"  → Solo números enteros (sin decimales).
 *      - "decimal" → Números con decimales (permitido un solo punto).
 *  - rango: Define el rango permitido:
 *      - "mixto"            → Permite tanto positivos como negativos.
 *      - "positivo"         → Restringe a valores positivos (incluye 0).
 *      - "positivo_sin_cero"→ Restringe a valores positivos mayores o iguales a 1.
 *      - "negativo"         → Restringe a valores negativos.
 *  - isRequired: Indica si el campo es obligatorio.
 *  - placeHolder: Texto de ayuda a mostrar cuando el input está vacío.
 */
const CNumberInput = ({
    name = '',
    value='',
    id='',
    style='',
    placeHolder="",
    tipo = 'entero',
    rango = 'mixto',
    isRequired = false
}) => {
  const handleInput = (e) => {
    let value = e.target.value;

    // 1. Filtrar caracteres según el tipo
    if (tipo === 'entero') {
      value = value.replace(/[^0-9\-]/g, '');
    } else if (tipo === 'decimal') {
      value = value.replace(',', '.');
      value = value.replace(/[^0-9.\-]/g, '');

      // Evita más de un punto decimal
      const parts = value.split('.');
      if (parts.length > 2) {
        value = parts[0] + '.' + parts.slice(1).join('');
      }
    }

    // 2. Validar el rango
    if (rango === 'positivo') {
      value = value.replace(/^-/, '');
    } else if (rango === 'positivo_sin_cero') {
      value = value.replace(/^-/, ''); // no negativos
      // Si el valor numérico es 0, se limpia
      if (value === '0' || value.startsWith('0') && !value.startsWith('0.')) {
        value = '';
      }
    } else if (rango === 'negativo') {
      if (!value.startsWith('-')) {
        value = '-' + value.replace(/^-/, '');
      }
    } else if (rango === 'mixto') {
      if (value.includes('-') && !value.startsWith('-')) {
        value = '-' + value.replace(/-/g, '');
      }
    }

    // 3. Actualizar el valor en el input
    e.target.value = value;
  };

  return (
    <input
      type="text"
      id={id}
      style={style}
      name={name}
      value={value}
      placeHolder={placeHolder}
      class="form-control"
      required={isRequired}
      onInput={handleInput}
    />
  );
};

export default CNumberInput;

