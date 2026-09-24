/**
 * Agrega saltos de línea al texto cuando excede la longitud máxima
 * @param {string} text - Texto a procesar
 * @param {number} maxLength - Longitud máxima por línea (default: 30)
 * @returns {string} - Texto con saltos de línea
 */
export const addLineBreaks = (text, maxLength = 30) => {
    if (!text) return 'sin descripcion';

    const words = text.split(' ');
    let result = '';
    let currentLine = '';

    for (let word of words) {
        if ((currentLine + word).length > maxLength) {
            result += currentLine.trim() + '\n';
            currentLine = word + ' ';
        } else {
            currentLine += word + ' ';
        }
    }

    result += currentLine.trim();
    return result;
};
