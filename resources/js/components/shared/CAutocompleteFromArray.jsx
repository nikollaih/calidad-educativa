import { h } from 'preact';
import { useState, useRef, useEffect } from 'preact/hooks';

const CAutocompleteFromArray = ({
                                    isEditable=true,
                                    data = [],
                                    onSelect,
                                    fieldName = '',
                                    valueField = 'id',         // Campo que se guarda como value real
                                    searchFields = [],         // Campos que se usan para buscar
                                    labelFields = [],           // Campos que se muestran en el desplegable
                                    initialValue = null,       // Valor inicial (ej: id),
                                    orderBy = null
                                }) => {
    const [displayValue, setDisplayValue] = useState('');
    const [selectedValue, setSelectedValue] = useState('');
    const [filtered, setFiltered] = useState([]);
    const [isOpen, setIsOpen] = useState(false);
    const wrapperRef = useRef(null);

        // --- función para ordenar con múltiples campos
    const sortData = (arr) => {
        if (!orderBy) return arr;

        const orderArray = Array.isArray(orderBy) ? orderBy : [orderBy];
        return [...arr].sort((a, b) => {
            for (let { field, direction } of orderArray) {
                const dir = direction?.toLowerCase() === 'desc' ? -1 : 1;
                if (a[field] < b[field]) return -1 * dir;
                if (a[field] > b[field]) return 1 * dir;
            }
            return 0;
        });
    };

    // Cerrar el menú si se hace clic afuera
    useEffect(() => {
        const handleClickOutside = (event) => {
            if (wrapperRef.current && !wrapperRef.current.contains(event.target)) {
                setIsOpen(false);
            }
        };
        document.addEventListener("mousedown", handleClickOutside);
        return () => document.removeEventListener("mousedown", handleClickOutside);
    }, []);

    // --- Preseleccionar valor inicial
    useEffect(() => {
        if (initialValue && data.length > 0) {
            const found = data.find(item => item[valueField] === initialValue);
            if (found) {
                const label = labelFields.map(f => String(found[f] ?? '')).join(' - ');
                setDisplayValue(label);
                setSelectedValue(found[valueField]);
            }
        }
    }, [initialValue, data]);

        // --- cuando cambia `data` o `orderBy`, reordenar
    useEffect(() => {
        setFiltered(sortData(data));
    }, [data, orderBy]);

    const handleInput = (e) => {
        const value = e.target.value;
        setDisplayValue(value);
        setSelectedValue('');

        if (value.trim() === '') {
            setFiltered(sortData(data));
            setIsOpen(true);
            return;
        }

        const results = data.filter(item =>
            searchFields.some(field =>
                String(item[field] ?? '')
                    .toLowerCase()
                    .includes(value.toLowerCase())
            )
        );

        setFiltered(sortData(results));
        setIsOpen(true);
    };


    const handleSelect = (item) => {
        // Texto visible: concatenamos los campos labelFields
        const label = labelFields
            .map(field => String(item[field] ?? ''))
            .join(' - ');

        setDisplayValue(label);
        setSelectedValue(item[valueField]);
        setIsOpen(false);

        if (onSelect) onSelect(item);
    };

     const handleFocus = () => {
        if (displayValue.trim() === '') {
            setFiltered(sortData(data));
        }
        setIsOpen(true);
    };

    return (
        <div ref={wrapperRef} class="relative w-full">
            {/* Input visible para el usuario */}
            <input
                type="text"
                value={displayValue}
                onInput={handleInput}
                onFocus={handleFocus}
                class="w-100 p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-400"
                placeholder="Buscar o seleccionar..."
                disabled={!isEditable}
                title={selectedValue ? displayValue : ''}  // 👈 Tooltip solo si hay un valor seleccionado
            />

            {/* Input oculto para enviar el valor real */}
            <input type="hidden" name={fieldName} value={selectedValue} />

            {isOpen && isEditable && filtered.length > 0 && (
                <ul class="absolute z-10 w-full max-h-60 overflow-y-auto bg-white border border-gray-300 rounded-lg shadow-lg mt-1">
                    {filtered.map((item) => {
                        const label = labelFields
                            .map(field => String(item[field] ?? ''))
                            .join(' - ');
                        return (
                            <li
                                key={item[valueField]}
                                onClick={() => handleSelect(item)}
                                class="p-2 hover:bg-blue-100 cursor-pointer"
                            >
                                {label}
                            </li>
                        );
                    })}
                </ul>
            )}
        </div>
    );
};

export default CAutocompleteFromArray;
