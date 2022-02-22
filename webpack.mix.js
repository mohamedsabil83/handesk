const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
//
// ]);

mix.babel(
    [
        //'resources/js/app.js',
        'vendor/badchoice/thrust/src/resources/js/thrust.min.js',
        'resources/js/utils.js',
        'resources/js/libs/jquery.tagsinput.min.js', //http://xoxco.com/projects/code/tagsinput/
        'resources/js/libs/mention.js/bootstrap-typeahead.js', //https://github.com/ivirabyan/jquery-mentions
        'resources/js/libs/mention.js/mention.js', //https://github.com/ivirabyan/jquery-mentions
    ],
    'public/js/app.js',
)
    .babel('resources/js/moment.min.js', 'public/js/moment.js')
    .less('resources/less/style.less', '../resources/css/style.css')
    .styles(['resources/css/libs/jquery.tagsinput.min.css', 'resources/css/style.css'], 'public/css/all.css');
