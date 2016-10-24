/**
 * index.js
 *
 * Binds all of our reducers into a single reducer that can be imported.
 * A reducer takes an existing state, executes the action and returns the new state.
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import {combineReducers} from 'redux';
import todos from './todos';
import visibilityFilter from './visibilityFilter';
import auth from './auth';

const TodoApp = combineReducers({
  todos,
  visibilityFilter,
  auth
});

export default TodoApp;