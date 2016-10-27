/**
 * index.js
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

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

export const getTodos = (payload) => {
  return {
    type: 'GET_TODOS',
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

export const storeClientToken = (payload) => {
  return {
    type: 'AUTH_CLIENT_TOKEN',
    payload
  }
};

export const storeAccessToken = (payload) => {
  return {
    type: 'AUTH_USER_TOKEN',
    payload
  }
};

export const logout = () => {
  return {
    type: 'AUTH_LOGOUT'
  }
};

export const updateLoader = (progress) => {
  return {
    type: 'UPDATE_LOADER',
    progress
  }
};