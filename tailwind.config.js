import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Helvetica', 'Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'theme' : '#ff7900',
                'sombre': '#121827'
            }
        },
    },

    plugins: [forms, require('flowbite/plugin')],
    darkMode:'media'
};
