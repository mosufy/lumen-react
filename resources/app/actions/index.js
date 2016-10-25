/**
 * index.js
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

export const addTodo = (text) => {
  return {
    type: 'ADD_TODO',
    id: Math.random().toString(36).slice(2),
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

export const resetTodo = () => {
  return {
    type: 'RESET_TODO'
  }
};

export const loginUser = (email, password) => {
  return {
    type: 'AUTH_AUTHENTICATE_USER',
    email,
    password
  }
};

export const isAuthenticated = () => {
  return {
    type: 'AUTH_AUTHENTICATED'
  }
};