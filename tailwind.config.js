const defaultTheme = require('tailwindcss/defaultTheme');
const  percentageWidth = require('tailwindcss-percentage-width');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            zIndex: {
                '-1': '-1',
            },
            flexGrow: {
                '5' : '5'
            },
            backgroundImage: {
                'hero-pattern': "url('/images/header_ellipse.png')",
            },
            colors: {
                'primary': {
                    '50': 'var(--color-primary-50)',
                    '100': 'var(--color-primary-100)',
                    '200': 'var(--color-primary-200)',
                    '300': 'var(--color-primary-300)',
                    '400': 'var(--color-primary-400)',
                    '500': 'var(--color-primary-500)',
                    '600': 'var(--color-primary-600)',
                    '700': 'var(--color-primary-700)',
                    '800': 'var(--color-primary-800)',
                    '900': 'var(--color-primary-900)',
                    '950': 'var(--color-primary-950)',
                },
                'secondary': {
                    '50': 'var(--color-secondary-50)',
                    '100': 'var(--color-secondary-100)',
                    '200': 'var(--color-secondary-200)',
                    '300': 'var(--color-secondary-300)',
                    '400': 'var(--color-secondary-400)',
                    '500': 'var(--color-secondary-500)',
                    '600': 'var(--color-secondary-600)',
                    '700': 'var(--color-secondary-700)',
                    '800': 'var(--color-secondary-800)',
                    '900': 'var(--color-secondary-900)',
                    '950': 'var(--color-secondary-950)',
                },
                'accent': {
                    '50': 'var(--color-accent-50)',
                    '100': 'var(--color-accent-100)',
                    '200': 'var(--color-accent-200)',
                    '300': 'var(--color-accent-300)',
                    '400': 'var(--color-accent-400)',
                    '500': 'var(--color-accent-500)',
                    '600': 'var(--color-accent-600)',
                    '700': 'var(--color-accent-700)',
                    '800': 'var(--color-accent-800)',
                    '900': 'var(--color-accent-900)',
                    '950': 'var(--color-accent-950)',
                },
                'success': {
                    '50': 'var(--color-success-50)',
                    '100': 'var(--color-success-100)',
                    '500': 'var(--color-success-500)',
                    '700': 'var(--color-success-700)',
                },
                'warning': {
                    '50': 'var(--color-warning-50)',
                    '100': 'var(--color-warning-100)',
                    '500': 'var(--color-warning-500)',
                    '700': 'var(--color-warning-700)',
                },
                'error': {
                    '50': 'var(--color-error-50)',
                    '100': 'var(--color-error-100)',
                    '500': 'var(--color-error-500)',
                    '700': 'var(--color-error-700)',
                },
                'tahiti': {
                    dark: '#242424',
                    primary: '#EFA02F'
                },
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        percentageWidth
    ],
};
