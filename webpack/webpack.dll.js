/**
 * webpack.dll.js
 *
 * Webpack’s DLLPlugin to build all dependencies into a single file.
 *
 * @date 27/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 *
 * To generate new dll file, simply run this command
 * $ node_modules/.bin/webpack --config=webpack/webpack.dll.js
 */

var path = require("path");
var webpack = require("webpack");
var AssetsPlugin = require('assets-webpack-plugin');

module.exports = {
  context: path.resolve(__dirname),
  entry: {
    vendor: ['./vendors.js']
  },
  output: {
    path: path.resolve(__dirname, '../public/js/dll'),
    filename: "dll.[name]-[hash].js",
    library: "[name]"
  },
  plugins: [
    new webpack.DllPlugin({
      path: path.resolve(__dirname, '../public/js/dll/[name]-manifest.json'),
      name: "[name]"
    }),
    new webpack.optimize.OccurrenceOrderPlugin(),
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        warnings: false
      }
    }),
    new webpack.DefinePlugin({
      'process.env':{
        'NODE_ENV': JSON.stringify('production')
      }
    }),
    new AssetsPlugin({
      filename: 'webpack.dll.manifest.json',
      path: path.resolve(__dirname)
    })
  ],
  resolve: {
    modules: [
      path.join(__dirname, "public"),
      "node_modules"
    ]
  }
};