let mix = require('laravel-mix');

const publicPath = 'public/vendor/core/plugins/location';
const resourcePath = './Plugins/location';

mix
    .js(resourcePath + '/resources/assets/js/location.js', publicPath + '/js')
    .copy(publicPath + '/js/location.js', resourcePath + '/public/js');
