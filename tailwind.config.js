import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'custom-primary': '#3878BB',
                'custom-blue-dark': '#2072B9',
                'custom-blue-light': '#1B9DD9',
                'custom-red': '#E7324C',
                'custom-gray': '#506372',
                'custom-gray-light': '#EEEDED',
            },
        },
    },

    plugins: [forms],
};
