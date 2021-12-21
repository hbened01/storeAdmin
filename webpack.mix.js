const mix = require('laravel-mix');

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

mix.styles([
        'resources/vendors/css/adminlte.min.css',
        'resources/vendors/css/all.min.css',
        'resources/vendors/css/daterangepicker.css',
        'resources/vendors/css/icheck-bootstrap.min.css',
        'resources/vendors/css/jqvmap.min.css',
        'resources/vendors/css/OverlayScrollbars.min.css',
        'resources/vendors/css/summernote-bs4.min.css',
        'resources/vendors/css/tempusdominus-bootstrap-4.min.css',
        'resources/vendors/css/config.css',
    ], 'public/css/all.css')
    .scripts([
        'resources/vendors/js/jquery.min.js',
        // 'resources/vendors/js/jquery3.11.min.js',
        'resources/vendors/js/jquery-ui.min.js',
        // 'resources/vendors/js/bootstrap.bundle.min.js',
        'resources/vendors/js/Chart.min.js',
        'resources/vendors/js/sparkline.js',
        'resources/vendors/js/jquery.vmap.min.js',
        'resources/vendors/js/jquery.vmap.usa.js',
        'resources/vendors/js/jquery.knob.min.js',
        'resources/vendors/js/moment.min.js',
        'resources/vendors/js/daterangepicker.js',
        'resources/vendors/js/tempusdominus-bootstrap-4.min.js',
        'resources/vendors/js/summernote-bs4.min.js',
        'resources/vendors/js/jquery.overlayScrollbars.min.js',
        'resources/vendors/js/adminlte.js',
        'resources/vendors/js/demo.js',
        'resources/vendors/js/dashboard.js'
    ], 'public/js/all.js')
    .js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copy('resources/vendors/css/webfonts/', 'public/webfonts')
    .copy('resources/vendors/img', 'public/img')
    .vue();