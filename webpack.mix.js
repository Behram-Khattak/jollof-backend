const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/admin.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/user.scss', 'public/css')
    .sass('resources/sass/admin.scss', 'public/css')
    .copyDirectory('node_modules/jollof-admin/theme/demo5/src/assets/media', 'public/images')
    .copyDirectory('node_modules/Jollof/images', 'public/images/jollof')
    .extract()
    .browserSync(process.env.APP_URL);


/**
 * plugins specific issue workaround for webpack
 * @see https://github.com/morrisjs/morris.js/issues/697
 * @see https://stackoverflow.com/questions/33998262/jquery-ui-and-webpack-how-to-manage-it-into-module
 */
mix.webpackConfig({
    resolve: {
        alias: {
            'morris.js': 'morris.js/morris.js',
            'jquery-ui': 'jquery-ui',
        },
    },
});
