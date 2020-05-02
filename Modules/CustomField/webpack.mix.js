let mix = require('laravel-mix');

const publicPath = 'public/vendor/core/plugins/custom-field';
const resourcePath = './Modules/CustomField';

mix
    .sass(resourcePath + '/Resources/assets/sass/edit-field-group.scss', publicPath + '/css')
    .copy(publicPath + '/css/edit-field-group.css', resourcePath + '/public/css')

    .sass(resourcePath + '/Resources/assets/sass/custom-field.scss', publicPath + '/css')
    .copy(publicPath + '/css/custom-field.css', resourcePath + '/public/css')

    .js(resourcePath + '/Resources/assets/js/edit-field-group.js', publicPath + '/js')
    .copy(publicPath + '/js/edit-field-group.js', resourcePath + '/public/js')

    .js(resourcePath + '/Resources/assets/js/use-custom-fields.js', publicPath + '/js')
    .copy(publicPath + '/js/use-custom-fields.js', resourcePath + '/public/js')

    .js(resourcePath + '/Resources/assets/js/import-field-group.js', publicPath + '/js')
    .copy(publicPath + '/js/import-field-group.js', resourcePath + '/public/js');
