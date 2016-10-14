/**
 * webpack.config.js
 *
 * @date 14/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

module.exports = {
  entry: "./resources/app/entry.js",
  output: {
    path: __dirname,
    filename: "public/js/bundle.js"
  },
  resolve: {
    extensions: ['', '.js', '.jsx']
  },
  module: {
    loaders: [
      {
        test: /\.jsx?$/,
        loader: 'babel-loader?presets[]=react,presets[]=es2015',
        exclude: /node_modules/
      }
    ]
  }
};
