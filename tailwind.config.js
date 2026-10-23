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
                sans: ['"DM Sans"', ...defaultTheme.fontFamily.sans],
                serif: ['"Playfair Display"', ...defaultTheme.fontFamily.serif],
            },
            colors: {
                matcha: {
                    cream: '#F1F4E7',
                    pale:  '#D8E2C7',
                    sage:  '#A7B892',
                    moss:  '#6B7F5B',
                    deep:  '#47563F',
                    sand:  '#CBBF9E',
                    warm:  '#E3DCC7',
                },
            },
        },
    },

    plugins: [forms],
};
