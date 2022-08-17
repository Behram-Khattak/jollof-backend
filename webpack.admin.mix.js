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

mix.js('resources/js/admin.js', 'public/js/admin/app.js')
    .sass('resources/sass/admin.scss', 'public/css/admin/app.css')
    .extract()
    .mergeManifest()
    .webpackConfig({
        resolve: {
            alias: {
                'morris.js': 'morris.js/morris.js',
                'jquery-ui': 'jquery-ui',
            },
        },
    });
