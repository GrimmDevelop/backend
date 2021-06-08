let mix = require('laravel-mix');
let path = require('path');

const tailwindcss = require('tailwindcss');

Mix.listen('configReady', webpackConfig => {
    webpackConfig.module.rules.forEach(rule => {
        if (Array.isArray(rule.use)) {
            rule.use.forEach(ruleUse => {
                if (ruleUse.loader === 'resolve-url-loader') {
                    ruleUse.options.engine = 'postcss';
                }
            });
        }
    });
});

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

mix
    // backend
    .vue()
    .js('resources/assets/js/misc.js', 'public/js')
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
    .sass('resources/assets/sass/app.scss', 'public/css', {
        additionalData: "$APP_ENV: '" + process.env.APP_ENV + "';"
    })
    .sass('resources/assets/sass/formats.scss', 'public/css')
    // frontend
    .js('resources/assets/frontend/js/frontend.js', 'public/frontend/js')
    .sass('resources/assets/frontend/sass/app.scss', 'public/frontend/css/')
    .options({
        processCssUrls: true,
        postCss: [
            tailwindcss('./tailwind.config.js'),
        ]
    })
    .copy('node_modules/tinymce/skins', 'public/frontend/js/skins')
    .copy('node_modules/tinymce/icons', 'public/js/icons')
    .alias({
        '@': path.resolve(__dirname, 'resources/assets'),
    })
    .sourceMaps();
