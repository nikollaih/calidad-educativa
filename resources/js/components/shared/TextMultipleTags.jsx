// src/ui/CNavigationButton.jsx
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
                              isEditable = true
                          }) => {
    const [tags, setTags] = useState(
        initialValue ? initialValue.split(',').map(tag => tag.trim()).filter(Boolean) : []
    );
    const [inputValue, setInputValue] = useState('');

    const addTag = () => {
        const trimmed = inputValue.trim();
        if (trimmed && !tags.includes(trimmed)) {
            setTags([...tags, trimmed]);
        }
        setInputValue('');
    };

    const removeTag = (indexToRemove) => {
        setTags(tags.filter((_, index) => index !== indexToRemove));
    };

    const handleKeyDown = (e) => {
        if (e.key === 'Enter' || e.key === ',') {
            e.preventDefault();
            addTag();
        }
    };

    return (
        <div class="mb-3">
            <label for={name} class="form-label">Nombre del Coordinador/es</label>
            <div class="form-control d-flex flex-wrap gap-2 p-2" style="min-height: 58px;">
                {tags.map((tag, index) => (
                    <span class="badge bg-primary d-flex align-items-center">
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
                />)}
            </div>

            {/* Este input contiene el valor real con comas */}
            <input type="hidden" name={name} value={tags.join(',')} />
        </div>
    );
};

export default TextMultipleTags;
