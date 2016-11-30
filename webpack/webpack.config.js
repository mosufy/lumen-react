/**
 * webpack.config.js
 *
 * @date 14/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

var path = require("path");
var webpack = require('webpack');
var AssetsPlugin = require('assets-webpack-plugin');

module.exports = {
  cache: true,
  entry: {
    bundle: ["./../resources/app/index.js"]
  },
  devtool: 'eval',
  output: {
    path: path.join(__dirname, '../', 'public', 'js'),
    filename: '[name]-dev-[hash].js'
  },
  resolve: {
    extensions: ['', '.js', '.jsx']
  },
  module: {
    loaders: [
      {
        test: /\.jsx?$/,
        exclude: /node_modules/,
        loader: 'babel',
        // include: [
        //   path.join(__dirname, "public")
        // ],
        query: {
          cacheDirectory: true,
          presets: ['es2015', 'stage-0', 'react']
        }
      }
    ]
  },
  plugins: [
    new webpack.DefinePlugin({
      'process.env': {
        'API_HOST': JSON.stringify('https://lumen-react.local/v1'),
        'API_CLIENT_ID': JSON.stringify('6fC2745co07D4yW7X9saRHpJcE0sm0MT'),
        'API_CLIENT_SECRET': JSON.stringify('KLqMw5D7g1c6KX23I72hx5ri9d16GJDW')
      }
    }),
    new webpack.DllReferencePlugin({
      context: ".",
      manifest: require(path.join(__dirname, '../', 'public', 'js', 'dll', 'vendor-manifest.json'))
    }),
    new AssetsPlugin({
      filename: 'webpack.dev.manifest.json'
    })
  ]
};