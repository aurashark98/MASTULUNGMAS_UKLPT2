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
                    red: '#DC2626',
                    'red-dark': '#991B1B',
                    orange: '#EA580C',
                    yellow: '#F59E0B',
                    dark: '#121212',
                    'dark-surface': '#1E1E1E',
                    'dark-card': '#252525',
                    brown: '#8B5A2B',
                    'brown-dark': '#6D4422',
                    'brown-light': '#A77543',
                },
                background: 'var(--background)',
                foreground: 'var(--foreground)',
                surface: 'var(--surface)',
                border: 'var(--border)',
                'body-text': 'var(--body-text)',
                'secondary-text': 'var(--secondary-text)',
                'footer-bg': 'var(--footer-bg)',
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
                'pulse-glow': 'pulse-glow 2s ease-in-out infinite',
                'slide-in-right': 'slide-in-right 0.6s ease-out forwards',
                'rotate-in': 'rotate-in 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) forwards',
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
                },
                'pulse-glow': {
                    '0%, 100%': { opacity: '1' },
                    '50%': { opacity: '0.7' },
                },
                'slide-in-right': {
                    '0%': { opacity: '0', transform: 'translateX(30px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                'rotate-in': {
                    '0%': { opacity: '0', transform: 'rotate(-10deg) scale(0.8)' },
                    '100%': { opacity: '1', transform: 'rotate(0) scale(1)' },
                }
            }
        },
    },

    plugins: [forms],
};
