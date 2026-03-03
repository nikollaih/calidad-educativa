import { h } from 'preact';
import { useState } from 'preact/hooks';

const EyeIcon = () => (
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
        <path strokeLinecap="round" strokeLinejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
        <path strokeLinecap="round" strokeLinejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
    </svg>
);

const EyeOffIcon = () => (
    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" strokeWidth={2}>
        <path strokeLinecap="round" strokeLinejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
    </svg>
);

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

    const toggleVisibility = () => setIsVisible(!isVisible);

    const handleChange = (e) => setPassword(e.target.value);

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
            <div class="relative flex items-center">
                <input
                    type={isVisible ? 'text' : 'password'}
                    name={name}
                    value={password}
                    required={isRequired}
                    onInput={handleChange}
                    onBlur={handleBlur}
                    placeholder="Ingrese su contraseña"
                    class={`w-full px-4 py-2 pr-10 rounded-full !border border-custom-blue-dark  transition-all ${
                        error
                            ? 'border-red-500 focus:ring-red-400'
                            : 'border-blue-900'
                    }`}
                />
                <button
                    type="button"
                    onClick={toggleVisibility}
                    class="absolute right-0 p-3 text-gray-500 hover:text-blue-900 transition-colors cursor-pointer"
                    aria-label={isVisible ? 'Ocultar contraseña' : 'Mostrar contraseña'}
                >
                    {isVisible ? <EyeIcon /> : <EyeOffIcon />}
                </button>
            </div>

            {error && (
                <p class="mt-1 text-sm text-red-600">{error}</p>
            )}
        </div>
    );
};

export default CPasswordInput;
