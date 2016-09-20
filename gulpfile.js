var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(function (mix) {
    // Copying vendor js
    mix.copy('bower_components/react/react.js', 'resources/assets/js/react.js');
    mix.copy('bower_components/react/react-dom.js', 'resources/assets/js/react-dom.js');
    mix.copy('bower_components/babel-standalone/babel.min.js', 'resources/assets/js/babel.min.js');

    // Compiling head js files
    mix.combine(['resources/assets/js/react.js', 'resources/assets/js/react-dom.js', 'resources/assets/js/babel.min.js'], 'public/js/head.js');
});