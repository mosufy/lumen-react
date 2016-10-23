/**
 * Main ReactJS app
 *
 * @date 8/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import React from 'react';
import ReactDOM from 'react-dom';
import {Provider} from 'react-redux';
import {createStore} from 'redux';
import {Router, browserHistory} from 'react-router';
import routes from './routes';
import TodoApp from './reducers/index';

let store = createStore(TodoApp);

ReactDOM.render(
  <Provider store={store}>
    <Router history={browserHistory} routes={routes}/>
  </Provider>,
  document.getElementById('root')
);