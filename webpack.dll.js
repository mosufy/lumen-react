/**
 * webpack.dll.js
 *
 * Webpack’s DLLPlugin to build all dependencies into a single file.
 *
 * @date 27/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

var path = require("path");
var webpack = require("webpack");

module.exports = {
  entry: {
    vendor: [path.join(__dirname, "vendors.js")]
  },
  output: {
    path: path.join(__dirname, "public", "js", "dll"),
    filename: "dll.[name].js",
    library: "[name]"
  },
  plugins: [
    new webpack.DllPlugin({
      path: path.join(__dirname, "public", "js", "dll", "[name]-manifest.json"),
      name: "[name]",
      context: __dirname
    }),
    new webpack.optimize.OccurenceOrderPlugin(),
    new webpack.optimize.UglifyJsPlugin({
      compress: {
        warnings: false
      }
    }),
    new webpack.DefinePlugin({
      'process.env':{
        'NODE_ENV': JSON.stringify('production')
      }
    })
  ],
  resolve: {
    root: path.resolve(__dirname, "public"),
    modulesDirectories: ["node_modules"]
  }
};