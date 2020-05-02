let mix = require('laravel-mix');

const publicPath = 'public/vendor/core/plugins/member';
const resourcePath = './Modules/Member';

mix
    .js(resourcePath + '/Resources/assets/js/member-admin.js', publicPath + '/js')
    .copy(publicPath + '/js/member-admin.js', resourcePath + '/public/js')

    .sass(resourcePath + '/Resources/assets/sass/member.scss', publicPath + '/css')
    .copy(publicPath + '/css/member.css', resourcePath + '/public/css');

mix
    .js(resourcePath + '/Resources/assets/js/app.js', publicPath + '/js')
    .copy(publicPath + '/js/app.js', resourcePath + '/public/js')
    .sass(resourcePath + '/Resources/assets/sass/app.scss', publicPath + '/css')
    .copy(publicPath + '/css/app.css', resourcePath + '/public/css');
