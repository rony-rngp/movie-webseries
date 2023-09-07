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

mix.js('resources/js/app.js', 'public/js')
    .vue()
    .sass('resources/sass/app.scss', 'public/css');

//---backend
 mix.sass('resources/sass/backend.scss', 'public/css/backend.css');

mix.js('resources/js/backend.js', 'public/js/backend.js');

mix.scripts([
    'public/backend/plugins/jquery/jquery.min.js',
    'public/backend/plugins/jquery-ui/jquery-ui.min.js',
    'public/backend/plugins/bootstrap/js/bootstrap.bundle.min.js',
    'public/backend/plugins/chart.js/Chart.min.js',
    'public/backend/plugins/sparklines/sparkline.js',
    'public/backend/plugins/jqvmap/jquery.vmap.min.js',
    'public/backend/plugins/jqvmap/maps/jquery.vmap.usa.js',
    'public/backend/plugins/jquery-knob/jquery.knob.min.js',
    'public/backend/plugins/moment/moment.min.js',
    'public/backend/plugins/daterangepicker/daterangepicker.js',
    'public/backend/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
    'public/backend/plugins/summernote/summernote-bs4.min.js',
    'public/backend/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
    'public/backend/dist/js/adminlte.js',
    //IziToast
    'public/js/iziToast.js',
    //DataTable
    'public/backend/plugins/datatables/jquery.dataTables.min.js',
    'public/backend/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
    'public/backend/plugins/datatables-responsive/js/dataTables.responsive.min.js',
    'public/backend/plugins/datatables-responsive/js/responsive.bootstrap4.min.js',
    //jQuery validation
    'public/backend/plugins/jquery-validation/jquery.validate.min.js',
    'public/backend/plugins/jquery-validation/additional-methods.min.js',
    //toggle
    'public/backend/toggle/bootstrap4-toggle.min.js',
    //sweetalert2
    'public/backend/sweetalert2/sweetalert2@9.js',
    //select2
    'public/backend/plugins/select2/js/select2.full.min.js',
],'public/js/backend_script.js');

