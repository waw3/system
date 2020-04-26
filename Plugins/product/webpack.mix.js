let mix = require('laravel-mix');

const publicPath = 'public/vendor/core/plugins/product';
const resourcePath = './Plugins/product';

mix
    .js(resourcePath + '/resources/assets/js/product.js', publicPath + '/js')
    .copy(publicPath + '/js/product.js', resourcePath + '/public/js');

    .js(resourcePath + '/resources/assets/js/features.js', publicPath + '/js')
    .copy(publicPath + '/js/features.js', resourcePath + '/public/js')

    .sass(resourcePath + '/resources/assets/sass/features.scss', publicPath + '/css')
    .copy(publicPath + '/css/features.css', resourcePath + '/public/css')

	.js(resourcePath + '/resources/assets/js/featurescurrencies.js', publicPath + '/js')
    .copy(publicPath + '/js/featurescurrencies.js', resourcePath + '/public/js')

    .sass(resourcePath + '/resources/assets/sass/featurescurrencies.scss', publicPath + '/css')
    .copy(publicPath + '/css/featurescurrencies.css', resourcePath + '/public/css');
