/**
 * todos.js
 *
 * TodoReducers. A reducer takes an existing state, executes the action and returns the new state.
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

const todo = (state = {}, action) => {
  switch (action.type) {
    case 'ADD_TODO':
      return {
        id: action.id,
        text: action.text,
        completed: false
      };
    default:
      return state
  }
};

const todos = (state = [], action) => {
  switch (action.type) {
    case 'ADD_TODO':
      if (action.text == '') {
        return state;
      }
      return [
        ...state,
        todo(undefined, action)
      ];
    default:
      return state
  }
};

export default todos;