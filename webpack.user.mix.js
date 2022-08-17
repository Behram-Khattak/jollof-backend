const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

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

mix.js('resources/js/app.js', 'public/js/user')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/user.scss', 'public/css/user/app.css')
    .extract()
    .mergeManifest()
    .browserSync(process.env.APP_URL);
