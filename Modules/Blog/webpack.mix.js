let mix = require('laravel-mix');

const publicPath = 'public/vendor/core/plugins/blog';
const resourcePath = './Plugins/blog';

mix
    .js(resourcePath + '/resources/assets/js/blog.js', publicPath + '/js')
    .copy(publicPath + '/js/blog.js', resourcePath + '/public/js');
