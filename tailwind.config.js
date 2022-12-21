/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './src/**/*.{html,js}',
        './node_modules/tw-elements/dist/js/**/*.js',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    plugins: [
        require('tw-elements/dist/plugin', '@tailwindcss/aspect-ratio')
    ]
}
