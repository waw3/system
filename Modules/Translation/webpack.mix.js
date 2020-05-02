let mix = require('laravel-mix');

const publicPath = 'public/vendor/core/plugins/translation';
const resourcePath = './Modules/Translation';

mix
    .js(resourcePath + '/Resources/assets/js/translation.js', publicPath + '/js')
    .copy(publicPath + '/js/translation.js', resourcePath + '/public/js')

    .sass(resourcePath + '/Resources/assets/sass/translation.scss', publicPath + '/css')
    .copy(publicPath + '/css/translation.css', resourcePath + '/public/css');
