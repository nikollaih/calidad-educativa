// src/ui/CBackButton.jsx
import { h } from 'preact';
import { useState } from 'preact/hooks';

/*
Este componente tiene como finalidad gestionar visualmente un string como
si fuera una lista de tags, pero internamente gestionandolo como un string
de manera que visualmente sea facil agregar varios textos sin tener que
concatenarlos uno a uno con comas
 */

const TextMultipleTags = ({
                              initialValue = '',
                              name = 'nombre_coordinadores',
                              isEditable = true,
                              label='Nombre del Coordinador/es',
                              spanClass = 'border p-2 rounded  d-flex align-items-center',
                              containerClass = 'px-3 py-2 rounded-pill d-flex flex-wrap gap-2 p-2',
                              onTagsChange
                          }) => {
    const [tags, setTags] = useState(
        initialValue ? initialValue.split(',').map(tag => tag.trim()).filter(Boolean) : []
    );
    const [inputValue, setInputValue] = useState('');

    const updateTags = (newTags) => {
        setTags(newTags);
        if (typeof onTagsChange === 'function') {
            onTagsChange(newTags.join(','));
        }
    };

    const addTag = () => {
        const trimmed = inputValue.trim();
        if (trimmed && !tags.includes(trimmed)) {
            updateTags([...tags, trimmed]);
        }
        setInputValue('');
    };

    const removeTag = (indexToRemove) => {
        updateTags(tags.filter((_, index) => index !== indexToRemove));
    };

    const handleKeyDown = (e) => {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            addTag();
        }
    };
    const disabledClasses = !isEditable
        ? 'border-gray-100 bg-gray-100 cursor-not-allowed'
        : '!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent';

    return (
        <div class="mb-3">
            {label && (<label htmlFor={name} className="block text-sm mb-2 ml-4">{label}</label>)}
            <div className={`${containerClass} ${disabledClasses}`}
                 style="min-height: 58px;">
                {tags.map((tag, index) => (
                    <span class={spanClass}>
                        {tag}
                        {( isEditable &&
                        <button
                            type="button"
                            class="btn-close btn-close-white btn-sm ms-2"
                            aria-label="Eliminar"
                            onClick={() => removeTag(index)}
                            style="font-size: 0.6rem;"
                        />)}
                    </span>
                ))}
                {( isEditable &&
                <input
                    type="text"
                    class="border-0 flex-grow-1"
                    style="min-width: 150px; outline: none;"
                    placeholder="Escribe y presiona enter o coma"
                    value={inputValue}
                    onInput={(e) => setInputValue(e.target.value)}
                    onKeyDown={handleKeyDown}
                    onBlur={addTag}
                />)}
            </div>

            {/* Este input contiene el valor real con comas */}
            <input type="hidden" name={name} value={tags.join(',')} />
        </div>
    );
};

export default TextMultipleTags;
