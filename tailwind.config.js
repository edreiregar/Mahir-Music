import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                ink: '#0F0F11',
                surface: '#17171A',
                raised: '#1E1E22',
                line: '#2C2C31',
                fog: '#F3F4F6',
                brand: { DEFAULT: '#FACC15', dark: '#EAB308' },
            },
            fontFamily: {
                sans: ['Archivo', ...defaultTheme.fontFamily.sans],
            },
        },
    },
    plugins: [],
};
