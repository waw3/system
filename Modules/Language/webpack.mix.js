let mix = require('laravel-mix');

const publicPath = 'public/vendor/core/plugins/language';
const resourcePath = './Modules/Language';

mix
    .js(resourcePath + '/Resources/assets/js/language.js', publicPath + '/js/language.js')
    .copy(publicPath + '/js/language.js', resourcePath + '/public/js')

    .js(resourcePath + '/Resources/assets/js/language-global.js', publicPath + '/js/language-global.js')
    .copy(publicPath + '/js/language-global.js', resourcePath + '/public/js')

    .js(resourcePath + '/Resources/assets/js/language-public.js', publicPath + '/js')
    .copy(publicPath + '/js/language-public.js', resourcePath + '/public/js')

    .sass(resourcePath + '/Resources/assets/sass/language.scss', publicPath + '/css')
    .copy(publicPath + '/css/language.css', resourcePath + '/public/css')

    .sass(resourcePath + '/Resources/assets/sass/language-public.scss', publicPath + '/css')
    .copy(publicPath + '/css/language-public.css', resourcePath + '/public/css');
