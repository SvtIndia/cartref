/** @type {import('tailwindcss').Config} */
const colors = require('tailwindcss/colors')

module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                "primary": colors.blue,
                // "theme":{
                //     50: '#fff1f2',
                //     100: '#ffe0e2',
                //     200: '#ffc6cb',
                //     300: '#ff9ea6',
                //     400: '#ff6672',
                //     500: '#fd293a',
                //     600: '#eb1728',
                //     700: '#c60f1e',
                //     800: '#a3111d',
                //     900: '#87151e',
                // },
                // "gray": colors.slate,
                "dark-1": "#000000",
                "dark-2": "#121417",
                "dark-3": "#101012",
                "dark-4": "#1F1F22",
                "light-1": "#FFFFFF",
                "light-2": "#EFEFEF",
                "light-3": "#7878A3",
                "light-4": "#5C5C7B",
                "gray-1": "#697C89",
            },
            animation: {
                'pulse-fast': 'pulse 0.8s linear infinite',
            }
        },
    },
    plugins: [],
}

