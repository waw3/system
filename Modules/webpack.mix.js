let mix = require('laravel-mix');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

const resourcePath = 'Modules';
const publicPath = 'public/vendor/core';
let fs = require('fs');

let themePath = resourcePath + '/Base/Resources/assets/sass/base/themes';
let paths = fs.readdirSync(themePath);
for (let i = 0; i < paths.length; i++) {
	if (paths[i].indexOf('.scss') > 0 && paths[i].charAt(0) !== '_') {
		let file = themePath + '/' + paths[i];
		mix.sass(file, publicPath + '/css/themes').copy(publicPath + '/css/themes/' + paths[i].replace('.scss', '.css'), resourcePath + '/Base/Resources/public/css/themes');
	}
}

mix
	.sass(resourcePath + '/Base/Resources/assets/sass/core.scss', publicPath + '/css')
	.copy(publicPath + '/css/core.css', resourcePath + '/Base/Resources/public/css')
	.sass(resourcePath + '/Base/Resources/assets/sass/custom/system-info.scss', publicPath + '/css')
	.copy(publicPath + '/css/system-info.css', resourcePath + '/Base/Resources/public/css')
	.sass(resourcePath + '/Base/Resources/assets/sass/custom/email.scss', publicPath + '/css')
	.copy(publicPath + '/css/email.css', resourcePath + '/Base/Resources/public/css')
	.js(resourcePath + '/Base/Resources/assets/js/app.js', publicPath + '/js')
	.copy(publicPath + '/js/app.js', resourcePath + '/Base/Resources/public/js')
	.js(resourcePath + '/Base/Resources/assets/js/core.js', publicPath + '/js')
	.copy(publicPath + '/js/core.js', resourcePath + '/Base/Resources/public/js');
// Modules Core
mix
	.js(resourcePath + '/Base/Resources/assets/js/editor.js', publicPath + '/js')
	.copy(publicPath + '/js/editor.js', resourcePath + '/Base/Resources/public/js')
	.js(resourcePath + '/Base/Resources/assets/js/cache.js', publicPath + '/js')
	.copy(publicPath + '/js/cache.js', resourcePath + '/Base/Resources/public/js')
	.js(resourcePath + '/Base/Resources/assets/js/tags.js', publicPath + '/js')
	.copy(publicPath + '/js/tags.js', resourcePath + '/Base/Resources/public/js')
	.js(resourcePath + '/Base/Resources/assets/js/system-info.js', publicPath + '/js')
	.copy(publicPath + '/js/system-info.js', resourcePath + '/Base/Resources/public/js')
	.js(resourcePath + '/setting/resources/assets/js/setting.js', publicPath + '/js')
	.copy(publicPath + '/js/setting.js', resourcePath + '/setting/public/js')
	.sass(resourcePath + '/setting/resources/assets/sass/setting.scss', publicPath + '/css')
	.copy(publicPath + '/css/setting.css', resourcePath + '/setting/public/css')
	.js(resourcePath + '/table/resources/assets/js/table.js', publicPath + '/js')
	.copy(publicPath + '/js/table.js', resourcePath + '/table/public/js')
	.js(resourcePath + '/table/resources/assets/js/filter.js', publicPath + '/js')
	.copy(publicPath + '/js/filter.js', resourcePath + '/table/public/js')
	.sass(resourcePath + '/table/resources/assets/sass/table.scss', publicPath + '/css/components')
	.copy(publicPath + '/css/components/table.css', resourcePath + '/table/public/css/components')
	.js(resourcePath + '/dashboard/resources/assets/js/dashboard.js', publicPath + '/js')
	.copy(publicPath + '/js/dashboard.js', resourcePath + '/dashboard/public/js')
	.js(resourcePath + '/acl/resources/assets/js/profile.js', publicPath + '/js')
	.copy(publicPath + '/js/profile.js', resourcePath + '/acl/public/js')
	.js(resourcePath + '/acl/resources/assets/js/login.js', publicPath + '/js')
	.copy(publicPath + '/js/login.js', resourcePath + '/acl/public/js')
	.js(resourcePath + '/acl/resources/assets/js/role.js', publicPath + '/js')
	.copy(publicPath + '/js/role.js', resourcePath + '/acl/public/js');
// Media
mix
	.sass(resourcePath + '/media/resources/assets/sass/media.scss', publicPath + '/media/css')
	.copy(publicPath + '/media/css/media.css', resourcePath + '/media/public/media/css')
	.js(resourcePath + '/media/resources/assets/js/media.js', publicPath + '/media/js')
	.copy(publicPath + '/media/js/media.js', resourcePath + '/media/public/media/js')
	.js(resourcePath + '/media/resources/assets/js/jquery.addMedia.js', publicPath + '/media/js')
	.copy(publicPath + '/media/js/jquery.addMedia.js', resourcePath + '/media/public/media/js')
	.js(resourcePath + '/media/resources/assets/js/integrate.js', publicPath + '/media/js')
	.copy(publicPath + '/media/js/integrate.js', resourcePath + '/media/public/media/js')

	.options({
		processCssUrls: false,
	});
