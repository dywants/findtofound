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
