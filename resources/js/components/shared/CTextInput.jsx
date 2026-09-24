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
      class="!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent w-full px-3 py-2 rounded-pill"
      required={isRequired}
      onInput={handleInput}
    />
  );
};

export default CTextInput;

