/**
 * webpack.production.config.js
 *
 * @date 27/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 *
 * To build webpack bundle, simply run this command
 * $ node_modules/.bin/webpack --config=webpack/webpack.production.config.js
 */

var path = require("path");
var webpack = require('webpack');
var AssetsPlugin = require('assets-webpack-plugin');

module.exports = {
  cache: true,
  context: path.resolve(__dirname, '../resources/app'),
  entry: {
    bundle: ['./index.js']
  },
  devtool: 'cheap-module-source-map',
  output: {
    filename: '[name]-production-[hash].js',
    path: path.resolve(__dirname, '../public/js'),
  },
  module: {
    rules: [
      {
        test: /\.jsx?$/,
        exclude: [/node_modules/],
        use: [
          {
            loader: 'babel-loader',
            options: {
              presets: ['es2015', 'stage-0', 'react']
            }
          }
        ]
      }
    ]
  },
  plugins: [
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        warnings: false
      }
    }),
    new webpack.DefinePlugin({
      'process.env': {
        'NODE_ENV': JSON.stringify('production'),
        'API_HOST': JSON.stringify('https://lumen-react.mosufy.com/v1'),
        'API_CLIENT_ID': JSON.stringify('6fC2745co07D4yW7X9saRHpJcE0sm0MT'),
        'API_CLIENT_SECRET': JSON.stringify('KLqMw5D7g1c6KX23I72hx5ri9d16GJDW')
      }
    }),
    new webpack.DllReferencePlugin({
      manifest: require('../public/js/dll/vendor-manifest.json')
    }),
    new AssetsPlugin({
      filename: 'webpack.production.manifest.json',
      path: path.resolve(__dirname)
    })
  ]
};