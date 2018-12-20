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

/** JS **/

mix.js('resources/assets/js/app.js', 'public/js');
mix.js('resources/assets/js/scripts.js', 'public/js');

mix.scripts([
    'resources/assets/js/scroll.js',
    'resources/assets/js/slick.js'
], 'public/js/all.js').version();

/** CSS **/

mix.styles(['resources/assets/css/plugins/slick.css',
    'resources/assets/css/plugins/v-tooltip.css',
    'node_modules/tooltipster/dist/css/tooltipster.bundle.min.css',
    'node_modules/tooltipster/dist/css/plugins/tooltipster/sideTip/themes/tooltipster-sideTip-borderless.min.css'
], 'public/css/plugins.css').sourceMaps().version();

// @temp will make a main.scss file in the future
mix.sass('resources/assets/sass/_social-links.scss', 'public/css/social-links.css')

mix.styles([
    'resources/assets/css/extras.css',
    'public/css/social-links.css' // @temp
], 'public/css/main.css').sourceMaps().version();

mix.postCss('resources/assets/css/styles.css', 'public/css', [
     tailwindcss('./tailwind.js'),
]).sourceMaps().version();

mix.styles('node_modules/@fortawesome/fontawesome-free/css/all.min.css', 'public/nova-api/styles/fontawesome.css');

/** Other **/

// mix.browserSync('http://localhost:8000');

