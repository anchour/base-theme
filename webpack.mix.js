let mix = require('laravel-mix');
let config = require('./resources/assets/build/config');


mix.setPublicPath('dist')
  .browserSync(config.devUrl);

mix
  .js(`${config.paths.assets}/scripts/main.js`, 'scripts');

mix
  .sass(`${config.paths.assets}/styles/main.scss`, 'styles');
