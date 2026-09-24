// src/ui/CInputComponent.jsx
import { h } from 'preact';
import { useState } from 'preact/hooks';
import TextMultipleTags from "@/components/shared/TextMultipleTags.jsx";
import CTextInput from "@/components/shared/CTextInput.jsx";

const CInputComponent = ({
                             label= '',
                             labelClass='block text-sm mb-2 ml-4',
                             inputType='text',
                             inputName = '',
                             inputClass = 'w-full px-3 py-2 rounded-pill ',
                             inputValue,
                             isDisabled = false,
                             isRequired = false
                         }) => {
    // Clases condicionales para el estado deshabilitado, se asume como detail
    const disabledClasses = isDisabled
        ? 'border-gray-100 bg-gray-100 cursor-not-allowed'
        : '!border border-custom-blue-dark focus:outline-none focus:ring-1 focus:ring-custom-blue-dark focus:border-transparent';

    // Renderiza el input
    const renderInput = () => {
         switch(inputType) {
             case 'text_multiple_tags':
                 return (
                     <TextMultipleTags
                         initialValue={inputValue}
                         isEditable={!isDisabled}
                     />
                 );
             case 'c_text_input':
                 return (
                     <CTextInput
                         name={inputName}
                         value={inputValue}
                         isRequired={isRequired}
                     />
                 );
            default:
                return (
                    <input
                        type={inputType}
                        name={inputName}
                        className={`${inputClass} ${disabledClasses}`}
                        value={inputValue}
                        disabled={isDisabled}
                    />
                );
        }
    };

    return (
        <div className="mb-3">
            <label className={labelClass}>{label} {isRequired && <span className="text-danger ml-1">*</span>}</label>
            {renderInput()}
        </div>
    );
};
export default CInputComponent;
