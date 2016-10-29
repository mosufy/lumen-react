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
import auth from './auth';
import user from './user';
import todos from './todos';
import visibilityFilter from './visibilityFilter';
import loading from './loading';

const TodoApp = combineReducers({
  auth,
  user,
  todos,
  visibilityFilter,
  loading,
});

export default TodoApp;