let mix = require('laravel-mix');
var tailwindcss = require('tailwindcss');

module.exports = {
    plugins: [
        // ...
        tailwindcss('./tailwind.js'),
        require('autoprefixer'),
        // ...
    ]
}

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */



mix.js('resources/assets/js/app.js', 'public/js');
mix.js('resources/assets/js/scripts.js', 'public/js');

mix.styles(['resources/assets/css/effects.css',
    'resources/assets/css/extras.css',
    'resources/assets/css/slick.css'
], 'public/css/main.css').sourceMaps().version();

mix.postCss('resources/assets/css/styles.css', 'public/css', [
     tailwindcss('./tailwind.js'),
]).sourceMaps().version();

mix.scripts([
    'resources/assets/js/scroll.js',
    'resources/assets/js/slick.js'
], 'public/js/all.js').version();

