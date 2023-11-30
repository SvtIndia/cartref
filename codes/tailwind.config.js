/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
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

