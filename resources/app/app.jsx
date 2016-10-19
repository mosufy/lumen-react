/**
 * Main ReactJS app
 *
 * @date 8/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import ReactDOM from 'react-dom';
// import {Provider} from 'react-redux';
// import {createStore, applyMiddleware} from 'redux';
import {Router, browserHistory} from 'react-router';
// import reduxThunk from 'redux-thunk';
import routes from './routes';
// import reducers from './reducers/index';
// import {AUTH_USER} from './actions/types';

ReactDOM.render(
  //<Provider store={store}>
    <Router history={browserHistory} routes={routes}/>,
  //</Provider>,
  document.getElementById('container')
);
