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

mix.js('resources/js/app.js', 'public/js')
   .js('resources/js/admin/app.js', 'public/admin/js')
   .js('resources/js/master.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css')
   .sass('resources/sass/_master.scss', 'public/css')
   .sass('resources/sass/admin/app.scss', 'public/admin/css')
   .sass('resources/sass/admin/dashboard.scss', 'public/admin/css');