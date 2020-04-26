let mix = require('laravel-mix');

const publicPath = 'public/vendor/core/plugins/audit-log';
const resourcePath = './Plugins/audit-log';

mix
    .js(resourcePath + '/resources/assets/js/audit-log.js', publicPath + '/js')
    .copy(publicPath + '/js/audit-log.js', resourcePath + '/public/js');