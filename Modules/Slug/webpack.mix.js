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

const resourcePath = 'Modules/Slug';
const publicPath = 'public/vendor/core/packages/slug';

mix
    .js(resourcePath + '/Resources/assets/js/slug.js', publicPath + '/js')
    .copy(publicPath + '/js/slug.js', resourcePath + '/public/js');
