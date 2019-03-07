const mix = require('laravel-mix');

mix
   .setResourceRoot('../../')
   .js('resources/js/app.js', 'assets/js')
   .sass('resources/sass/app.scss', 'assets/css')
   .copy('resources/images', 'assets/images', false)
   .mix.setPublicPath('')
   .browserSync({
      proxy: 'localhost/camarih_dev/',
      files: [
         'resources/js/*',
         'application/views/*'
      ]
   })