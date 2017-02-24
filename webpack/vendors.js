/**
 * List of vendor files to import when building webpack
 *
 * @date 27/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 *
 * To generate new dll file, simply run this command
 * $ node_modules/.bin/webpack --config=webpack/webpack.dll.js
 */

require("lodash/throttle");
require("react");
require("react-dom");
require("react-redux");
require("react-router");
require("redux");
require("redux-thunk");
require("react-ladda");
require("axios");