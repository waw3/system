const mix = require('laravel-mix');
require('laravel-mix-merge-manifest');

mix.setPublicPath('../../public').mergeManifest();

mix
  .options({
    terser: {
      terserOptions: {
        compress: {
          drop_console: true
        }
      }
    }
  })
  .setPublicPath("public")
  .js("resources/js/app.js", "public")
  .sass("resources/sass/app.scss", "public")
  .styles([
      'resources/sass/style.css',
  ], 'public/all.css')
  .version()
  .webpackConfig({
    resolve: {
      symlinks: false,
      alias: {
        "@": path.resolve(__dirname, "resources/js/")
      }
    },
    plugins: [new webpack.IgnorePlugin(/^\.\/locale$/, /moment$/)]
  });

if (mix.inProduction()) {
    mix.version();
}
