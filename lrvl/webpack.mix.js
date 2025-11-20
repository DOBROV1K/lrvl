// webpack.mix.js
const mix = require('laravel-mix');

mix.setPublicPath('public');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/styles.scss', 'public/css')
   .sourceMaps();

mix.copyDirectory('resources/assets', 'public/assets'); 
