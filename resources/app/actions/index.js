/**
 * index.js
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

let nextTodoId = 0;

export const addTodo = (text) => {
  return {
    type: 'ADD_TODO',
    id: nextTodoId++,
    text
  }
};

export const toggleCompleted = (id) => {
  return {
    type: 'TOGGLE_COMPLETED',
    id: id
  }
};

export const setVisibilityFilter = (filter) => {
  return {
    type: 'SET_VISIBILITY_FILTER',
    filter
  }
};

export const loginUser = (email, password) => {
  return {
    type: 'AUTH_LOGIN_USER',
    email,
    password
  }
};