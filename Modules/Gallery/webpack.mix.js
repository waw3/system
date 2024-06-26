let mix = require('laravel-mix');

const publicPath = 'public/vendor/core/plugins/gallery';
const resourcePath = './Modules/Gallery';

mix
    .sass(resourcePath + '/Resources/assets/sass/gallery.scss', publicPath + '/css')
    .copy(publicPath + '/css/gallery.css', resourcePath + '/public/css')

    .sass(resourcePath + '/Resources/assets/sass/object-gallery.scss', publicPath + '/css')
    .copy(publicPath + '/css/object-gallery.css', resourcePath + '/public/css')

    .sass(resourcePath + '/Resources/assets/sass/admin-gallery.scss', publicPath + '/css')
    .copy(publicPath + '/css/admin-gallery.css', resourcePath + '/public/css')

    .js(resourcePath + '/Resources/assets/js/gallery.js', publicPath + '/js/gallery.js')
    .copy(publicPath + '/js/gallery.js', resourcePath + '/public/js')

    .js(resourcePath + '/Resources/assets/js/object-gallery.js', publicPath + '/js/object-gallery.js')
    .copy(publicPath + '/js/object-gallery.js', resourcePath + '/public/js');
