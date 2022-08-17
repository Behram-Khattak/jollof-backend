const path = require('path');
const ComponentFactory = require('laravel-mix/src/components/ComponentFactory');
const WebpackConfig = require('laravel-mix/src/builder/WebpackConfig');
const mix = require('laravel-mix');

/**
 * Export the configurations build for each assets target.
 *
 * @type {Promise<any[]>}
 *
 * @link https://webpack.js.org/configuration/configuration-types/#exporting-multiple-configurations
 */
module.exports = Promise.all(['admin', 'user'].map(async target => {
    /**
     * As our first step, global variables are build or
     * reset with default value.
     */
    global.File = require('laravel-mix/src/File');
    global.Config = require('laravel-mix/src/config')();
    global.Config.publicPath = 'public';
    global.Mix = new (require('laravel-mix/src/Mix'))();

    /**
     * We'll pull in the user's mix file.
     * Based on what the user requests in that file,
     * a generic config object will be constructed for us.
     */
    new ComponentFactory().installAll();
    require(path.join(__dirname, `webpack.${target}.mix`));

    /**
     * Just in case the user needs to hook into this point
     * in the build process, we'll make an announcement.
     */
    Mix.dispatch('init', Mix);

    /**
     * Now that we know which build tasks are required by the
     * user, we can dynamically create a configuration object
     * for Webpack. And that's all there is to it. Simple!
     */
    const config = new WebpackConfig().build();
    config.name = target;

    return config
}));

mix.copy(['node_modules/Jollof/images/', 'node_modules/jollof-admin/theme/demo5/src/assets/media/'], 'public/images',)
    .disableNotifications();


if (mix.inProduction()) {
    mix.version();
}
