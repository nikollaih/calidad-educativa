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

/** Compara textos agrupando primero etiquetas que inician en mayuscula. */
export const compareSelectorText = (left, right) => {
    const leftText = String(left ?? '');
    const rightText = String(right ?? '');
    const caseRank = (text) => {
        const first = text.charAt(0);
        if (!first) return 0;
        if (first === first.toLocaleUpperCase() && first !== first.toLocaleLowerCase()) return 0;
        if (first === first.toLocaleLowerCase() && first !== first.toLocaleUpperCase()) return 1;
        return 0;
    };
    const rankDifference = caseRank(leftText) - caseRank(rightText);
    if (rankDifference !== 0) return rankDifference;

    return leftText.localeCompare(rightText, 'es', {
        caseFirst: 'upper',
        sensitivity: 'variant',
        numeric: true,
    });
};

export const sortBySelectorText = (items, getText) =>
    [...(items ?? [])].sort((left, right) =>
        compareSelectorText(getText(left), getText(right))
    );

export const withSelectorNameOrder = (url) => {
    const separator = String(url).includes('?') ? '&' : '?';
    return `${url}${separator}sort=nombre&direction=asc`;
};
