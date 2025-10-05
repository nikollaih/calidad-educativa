import { h } from 'preact';

const CTextInput = ({ name = '', value='', isRequired = false }) => {
  const handleInput = (e) => {
    // Reemplaza todo lo que no sea letras ni espacios
    e.target.value = e.target.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
  };

  return (
    <input
      type="text"
      name={name}
      value={value}
      class="form-control"
      required={isRequired}
      onInput={handleInput}
    />
  );
};

export default CTextInput;

