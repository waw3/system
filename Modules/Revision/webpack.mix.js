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

const resourcePath = 'Modules/Revision/';
const publicPath = 'public/vendor/core/packages/revision';

mix
    .sass(resourcePath + '/Resources/assets/sass/revision.scss', publicPath + '/css')
    .copy(publicPath + '/css/revision.css', resourcePath + '/public/css')

    .js(resourcePath + '/Resources/assets/js/revision.js', publicPath + '/js')
    .copy(publicPath + '/js/revision.js', resourcePath + '/public/js');
