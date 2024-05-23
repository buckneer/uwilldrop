/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {

        extend: {
            transitionProperty: {
                'left': 'left',
            },
            colors: {
                "primary": '#0f1318',
                "secondary": '#40A2D8',
                "accent": "#1e232d",
                "text-color": "#F0EDCF",
                "muted": "#526070"
            }
        },
    },
    plugins: [],
}
