/**
 * todoActions
 *
 * @date 28/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import * as sdk from './../helpers/sdk';
import {updateLoader} from './commonActions';

export const addTodo = (payload) => {
  return {
    type: 'ADD_TODO',
    payload
  }
};

export const toggleCompleted = (id, payload = {}) => {
  return {
    type: 'TOGGLE_COMPLETED',
    id: id,
    payload
  }
};

export const populateTodos = (payload) => {
  return {
    type: 'POPULATE_TODOS',
    payload
  }
};

export const setVisibilityFilter = (filter) => {
  return {
    type: 'SET_VISIBILITY_FILTER',
    filter
  }
};

export const resetTodo = () => {
  return {
    type: 'RESET_TODO'
  }
};

export const getTodos = () => {
  return (dispatch, getState) => {
    return sdk.getTodos(getState().auth.accessToken)
      .then((response) => {
        dispatch(populateTodos(response));
      })
      .catch((error) => {
        console.log('Failed to get todos');
        console.log(error);
      });
  }
};

export const insertTodo = (text) => {
  return (dispatch, getState) => {
    dispatch(updateLoader(0.5));

    if (text == '') {
      dispatch(updateLoader(1));
      return Promise.resolve();
    }

    return sdk.insertTodo(getState().auth.accessToken, text)
      .then((response) => {
        dispatch(addTodo(response));
        dispatch(updateLoader(1));
      })
      .catch((error) => {
        dispatch(updateLoader(1));
        console.log('Failed to insert todo');
        console.log(error);
      });
  }
};

export const toggleTodo = (id) => {
  return (dispatch, getState) => {
    return sdk.toggleTodo(getState().auth.accessToken, id)
      .then((response) => {
        dispatch(toggleCompleted(id, response));
      })
      .catch((error) => {
        console.log('Failed to toggle Todo');
        console.log(error);
      });
  }
};

export const deleteTodos = () => {
  return (dispatch, getState) => {
    dispatch(resetTodo());
    return sdk.deleteAllTodos(getState().auth.accessToken)
      .catch((error) => {
        console.log('Failed to delete all Todos');
        console.log(error);
      });
  }
};