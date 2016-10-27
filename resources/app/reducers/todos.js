/**
 * todos.js
 *
 * TodoReducers. A reducer takes an existing state, executes the action and returns the new state.
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

const todos = (state = [], action) => {
  switch (action.type) {
    case 'ADD_TODO':
      if (action.text == '') {
        return state;
      }

      return [
        ...state,
        {
          id: action.id,
          text: action.text,
          completed: false
        }
      ];
    case 'TOGGLE_COMPLETED':
      return state.map(todo => {
        if (todo.id != action.id) {
          return todo;
        }

        return {
          ...todo,
          completed: !todo.completed
        }
      });
    case 'RESET_TODO':
      return [];
    case 'GET_TODOS':
      var todos = action.payload.data.data;
      var items = [];
      for (var i = 0; i < todos.length; i++) {
        items.push({
          id: todos[i].attributes.id,
          text: todos[i].attributes.title,
          completed: todos[i].attributes.isCompleted
        });
      }
      return items;
    default:
      return state
  }
};

export default todos;