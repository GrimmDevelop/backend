let mix = require('laravel-mix');

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

mix.js('resources/assets/js/misc.js', 'public/js')
    .js('resources/assets/js/associations/associations.js', 'public/js')
    .js('resources/assets/js/letters/associations.js', 'public/js/letters')
    .js('resources/assets/js/persons/persons.js', 'public/js')
    .js('resources/assets/js/library/library.js', 'public/js')
    .js('resources/assets/js/library/scans.js', 'public/js/library-scans.js')
    .js('resources/assets/js/letters/letters.js', 'public/js')
    .js('resources/assets/js/letters/letter.js', 'public/js')
    .js('resources/assets/js/letters/scans.js', 'public/js/letters-scans.js')
    .js('resources/assets/js/deployment/deployment.js', 'public/js')
    .js('resources/assets/js/import/import.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css');
