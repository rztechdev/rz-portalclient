import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import colors from 'tailwindcss/colors';

const rzSageGreen = {
    50: '#f6f7f3',
    100: '#e9ede1',
    200: '#d5dec8',
    300: '#bccbaa',
    400: '#a2b187', // RZ Primary (#A2B187)
    500: '#8b9b70', // RZ Deep (#8B9B70 - Main Brand Green from rz - about)
    600: '#7a8a60', // RZ Deep Hover (#7A8A60)
    700: '#64724e',
    800: '#525d40',
    900: '#444d36',
    950: '#252b1d',
    DEFAULT: '#8b9b70',
};

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            fontFamily: {
                sans: ['Plus Jakarta Sans', 'Inter', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            borderRadius: {
                none: '0',
                xs: 'calc(0.625rem - 6px)',
                sm: 'calc(0.625rem - 4px)',
                DEFAULT: 'calc(0.625rem - 2px)',
                md: 'calc(0.625rem - 2px)',
                lg: '0.625rem', // 10px TweakCN radius
                xl: '0.625rem',
                '2xl': '0.625rem',
                '3xl': '0.625rem',
                full: '9999px',
            },
            boxShadow: {
                xs: '0 1px 2px 0 rgba(0, 0, 0, 0.05)',
                sm: '0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1)',
                DEFAULT: '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1)',
                md: '0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1)',
                lg: '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1)',
                xl: '0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1)',
                '2xl': '0 25px 50px -12px rgba(0, 0, 0, 0.25)',
            },
            colors: {
                brand: rzSageGreen,
                rz: rzSageGreen,
                emerald: rzSageGreen,
                indigo: rzSageGreen,
                gray: colors.zinc,
                slate: colors.zinc,
            },
        },
    },

    plugins: [forms],
};
