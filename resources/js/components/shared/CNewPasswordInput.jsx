import { h } from 'preact';
import { useState } from 'preact/hooks';

const CPasswordInput = ({
                            name = '',
                            value = '',
                            isRequired = false,
                            minLength = 8,
                            maxLength = 20,
                            className = ''
                        }) => {
    const [isVisible, setIsVisible] = useState(false);
    const [password, setPassword] = useState(value);
    const [error, setError] = useState('');
    const [isFocused, setIsFocused] = useState(false);

    const toggleVisibility = () => {
        setIsVisible(!isVisible);
    };

    const handleChange = (e) => {
        setPassword(e.target.value);
    };

    const handleBlur = () => {
        setIsFocused(false);
        if (password.length < minLength) {
            setError(`La contraseña debe tener al menos ${minLength} caracteres.`);
        } else if (password.length > maxLength) {
            setError(`La contraseña no debe superar los ${maxLength} caracteres.`);
        } else {
            setError('');
        }
    };

    const handleFocus = () => {
        setIsFocused(true);
    };

    return (
        <div>
            <div class={`flex items-center w-full px-3  !border border-custom-blue-dark rounded-pill transition-all ${isFocused ? 'ring-1 ring-custom-blue-dark' : ''}`}>
                <input
                    type={isVisible ? 'text' : 'password'}
                    name={name}
                    value={password}
                    required={isRequired}
                    onInput={handleChange}
                    onBlur={handleBlur}
                    onFocus={handleFocus}
                    class="flex-1 border-0 outline-none focus:outline-none focus:ring-0 focus:border-0 bg-transparent"
                    placeholder="Ingrese su contraseña"
                    style={{ boxShadow: 'none' }}
                />

                <button
                    type="button"
                    class="ml-2 text-gray-600 hover:text-gray-800 focus:outline-none flex-shrink-0 text-base"
                    onClick={toggleVisibility}
                    style={{ cursor: 'pointer', fontSize: '16px' }}
                    tabIndex={-1}
                >
                    <i class={`fa ${isVisible ? 'fa-eye' : 'fa-eye-slash'}`}></i>
                </button>
            </div>

            {error && (
                <div class="text-red-500 text-xs mt-1 ml-4">{error}</div>
            )}
        </div>
    );
};

export default CPasswordInput;
