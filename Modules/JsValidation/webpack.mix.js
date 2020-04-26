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

const resourcePath = 'Modules/Jsvalidation';
const publicPath = 'public/vendor/core';

mix
    .scripts(
        [
            resourcePath + '/Resources/assets/js/jquery-validation/jquery.validate.js',
            resourcePath + '/Resources/assets/js/phpjs/strlen.js',
            resourcePath + '/Resources/assets/js/phpjs/array_diff.js',
            resourcePath + '/Resources/assets/js/phpjs/strtotime.js',
            resourcePath + '/Resources/assets/js/phpjs/is_numeric.js',
            resourcePath + '/Resources/assets/js/php-date-formatter/php-date-formatter.js',
            resourcePath + '/Resources/assets/js/jsvalidation.js',
            resourcePath + '/Resources/assets/js/helpers.js',
            resourcePath + '/Resources/assets/js/timezones.js',
            resourcePath + '/Resources/assets/js/validations.js'
        ], publicPath + '/js/jsvalidation.js')
    .copy(publicPath + '/js/jsvalidation.js', resourcePath + '/public/js');
