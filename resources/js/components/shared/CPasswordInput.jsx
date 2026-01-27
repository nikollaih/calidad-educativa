import { h } from 'preact';
import { useState } from 'preact/hooks';

/**
 * @deprecated Este componente usa estilos de Bootstrap y será reemplazado.
 * Utiliza la nueva versión del componente con estilos de Tailwind.
 */
const CPasswordInput = ({
  name = '',
  value = '',
  isRequired = false,
  minLength = 8,
  maxLength = 20
}) => {
  const [isVisible, setIsVisible] = useState(false);
  const [password, setPassword] = useState(value);
  const [error, setError] = useState('');

  const toggleVisibility = () => {
    setIsVisible(!isVisible);
  };

  const handleChange = (e) => {
    setPassword(e.target.value);
  };

  const handleBlur = () => {
    if (password.length < minLength) {
      setError(`La contraseña debe tener al menos ${minLength} caracteres.`);
    } else if (password.length > maxLength) {
      setError(`La contraseña no debe superar los ${maxLength} caracteres.`);
    } else {
      setError('');
    }
  };

  return (
    <div class="mb-3">
      <div class="input-group">
        <input
          type={isVisible ? 'text' : 'password'}
          name={name}
          value={password}
          required={isRequired}
          onInput={handleChange}
          onBlur={handleBlur}
          class="form-control"
          placeholder="Ingrese su contraseña"
        />

        <button
          type="button"
          class="input-group-text bg-transparent border-start-0"
          onClick={toggleVisibility}
          style={{ cursor: 'pointer' }}
          tabIndex={-1}
        >
          <i class={`fa ${isVisible ? 'fa-eye' : 'fa-eye-slash'}`}></i>
        </button>
      </div>

      {error && (
        <div class="text-danger small mt-1">{error}</div>
      )}
    </div>
  );
};

export default CPasswordInput;

