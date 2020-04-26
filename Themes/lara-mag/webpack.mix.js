let mix = require('laravel-mix');

const resourcePath = 'Themes/lara-mag';
const publicPath = 'public/themes/lara-mag';

mix
    .sass(resourcePath + '/assets/sass/lara-mag.scss', publicPath + '/css')
    .copy(publicPath + '/css/lara-mag.css', resourcePath + '/public/css')
    .scripts(
        [
            resourcePath + '/assets/js/jquery.min.js',
            resourcePath + '/assets/js/custom.js',
            resourcePath + '/assets/js/jquery.fancybox.min.js'
        ], publicPath + '/js/lara-mag.js')
    .copy(publicPath + '/js/lara-mag.js', resourcePath + '/public/js');
