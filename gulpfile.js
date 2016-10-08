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
  mix.copy('node_modules/react/dist/react.min.js', 'resources/assets/js/react.min.js');
  mix.copy('node_modules/react-dom/dist/react-dom.min.js', 'resources/assets/js/react-dom.min.js');
  mix.copy('node_modules/babel-standalone/babel.min.js', 'resources/assets/js/babel.min.js');

  // Copy all JS files to public js folder
  mix.copy('resources/assets/js', 'public/js')
});