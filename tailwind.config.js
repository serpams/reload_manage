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
        },
    },

    plugins: [require("daisyui"), forms],
    daisyui: {
        themes: [
            {
                gmaisp: {
                    primary: "#1c1917",
                    secondary: "#78716c",
                    accent: "#292524",
                    neutral: "#57534e",
                    "base-100": "#F5F5F4",
                    info: "#0369a1",
                    success: "#15803d",
                    warning: "#eab308",
                    error: "#b91c1c",
                },
            },
        ],
    },
};
