import { h } from 'preact';

/**
 * Componente CNumberInput
 *
 * Es un input de texto personalizado para el ingreso de números
 * que permite controlar:
 *  - El tipo de número (entero o decimal).
 *  - El rango de valores permitidos (positivo, negativo o mixto).
 *
 * Props:
 *  - name: Nombre del campo (atributo name del input).
 *  - value: Valor inicial/controlado del input.
 *  - tipo: Define si el número debe ser:
 *      - "entero"  → Solo números enteros (sin decimales).
 *      - "decimal" → Números con decimales (permitido un solo punto).
 *  - rango: Define el rango permitido:
 *      - "mixto"     → Permite tanto positivos como negativos.
 *      - "positivo"  → Restringe a valores positivos.
 *      - "negativo"  → Restringe a valores negativos.
 *  - isRequired: Indica si el campo es obligatorio.
 *  - placeHolder: Texto de ayuda a mostrar cuando el input está vacío.
 */
const CNumberInput = ({
    name = '',
    value='',
    placeHolder="",
    tipo = 'entero',
    rango = 'mixto',
    isRequired = false
}) => {
  // Manejador del evento input: procesa y valida cada valor digitado
  const handleInput = (e) => {
    let value = e.target.value;

    // 1. Filtrar caracteres según el tipo
    if (tipo === 'entero') {
      // Solo se permiten dígitos y opcionalmente el signo "-"
      value = value.replace(/[^0-9\-]/g, '');
    } else if (tipo === 'decimal') {
      value = value.replace(',', '.');

      // Se permiten dígitos, un punto decimal y el signo "-"
      value = value.replace(/[^0-9\.\-]/g, '');

      // Evita que el usuario ponga más de un punto decimal
      const parts = value.split('.');
      if (parts.length > 2) {
        value = parts[0] + '.' + parts.slice(1).join('');
      }
    }

    // 2. Validar el rango
    if (rango === 'positivo') {
      // Si el rango es positivo, se elimina cualquier signo negativo
      value = value.replace(/^-/, '');
    } else if (rango === 'negativo') {
      // Si el rango es negativo, siempre forzamos el signo "-"
      if (!value.startsWith('-')) {
        value = '-' + value.replace(/^-/, '');
      }
    }

    // 3. Actualizar el valor en el input
    e.target.value = value;
  };

  return (
    <input
      type="text"
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

