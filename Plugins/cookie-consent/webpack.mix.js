let mix = require('laravel-mix');

const resourcePath = 'Modules/Plugins/cookie-consent';
const publicPath = 'public/vendor/core/plugins/cookie-consent';

mix
    .sass(resourcePath + '/resources/assets/sass/cookie-consent.scss', publicPath + '/css')
    .copy(publicPath + '/css/cookie-consent.css', resourcePath + '/public/css');
