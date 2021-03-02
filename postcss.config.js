/* eslint-disable */
const path = require('path');
const cssnanoConfig = {
  preset: ['default', { discardComments: { removeAll: true } }]
};

const config = require('./config');

module.exports = {
  parser: config.enabled.optimize ? 'postcss-safe-parser' : undefined,
  plugins: {
    autoprefixer: true,
    tailwindcss: path.resolve(config.paths.assets, 'styles/tailwind.config.js'),
    cssnano: config.enabled.optimize ? cssnanoConfig : false,
  },
};
