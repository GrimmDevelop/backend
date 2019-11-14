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
    .js('resources/assets/js/people/person.js', 'public/js')
    .js('resources/assets/js/library/relation.js', 'public/js/library-relation.js')
    .js('resources/assets/js/library/books.js', 'public/js/library-books.js')
    .js('resources/assets/js/library/book.js', 'public/js/library-book.js')
    .js('resources/assets/js/library/people.js', 'public/js/library-people.js')
    .js('resources/assets/js/library/person.js', 'public/js/library-person.js')
    .js('resources/assets/js/library/scans.js', 'public/js/library-scans.js')
    .js('resources/assets/js/letters/letters.js', 'public/js')
    .js('resources/assets/js/letters/letter.js', 'public/js')
    .js('resources/assets/js/letters/scans.js', 'public/js/letters-scans.js')
    .js('resources/assets/js/letters/apparatuses.js', 'public/js/letters-apparatuses.js')
    .js('resources/assets/js/letters/lettertext.js', 'public/js/letters-lettertext.js')
    .js('resources/assets/js/deployment/deployment.js', 'public/js')
    .js('resources/assets/js/import/import.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .sass('resources/assets/sass/formats.scss', 'public/css');
