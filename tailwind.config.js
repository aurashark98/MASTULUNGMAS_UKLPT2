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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                poppins: ['Poppins', 'sans-serif'],
            },
            colors: {
                mtm: {
                    red: '#D32F2F',
                    'red-dark': '#B71C1C',
                    'red-light': '#EF5350',
                    brown: '#8B5A2B',
                    'brown-dark': '#6D4422',
                    'brown-light': '#A67C52',
                    dark: '#0A0A0A',
                    'dark-surface': '#141414',
                    'dark-border': '#1F1F1F',
                },
                background: 'var(--background)',
                foreground: 'var(--foreground)',
            },
            backgroundImage: {
                'gradient-premium': 'linear-gradient(to right, #D32F2F, #8B5A2B)',
                'gradient-premium-hover': 'linear-gradient(to right, #B71C1C, #6D4422)',
            },
            animation: {
                'bounce-slow': 'bounce-slow 3s infinite ease-in-out',
                'fade-in': 'fade-in 0.6s ease-out forwards',
                'fade-up': 'fade-up 0.8s ease-out forwards',
                'scale-in': 'scale-in 0.5s cubic-bezier(0.165, 0.84, 0.44, 1) forwards',
                'float': 'float 6s ease-in-out infinite',
            },
            keyframes: {
                'bounce-slow': {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-15px)' },
                },
                'fade-in': {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                'fade-up': {
                    '0%': { opacity: '0', transform: 'translateY(30px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                'scale-in': {
                    '0%': { opacity: '0', transform: 'scale(0.9)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
                'float': {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-20px)' },
                }
            }
        },
    },

    plugins: [forms],
};
