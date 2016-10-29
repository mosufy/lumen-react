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
      return [
        ...state,
        {
          id: action.payload.data.data[0].attributes.uid,
          text: action.payload.data.data[0].attributes.title,
          completed: action.payload.data.data[0].attributes.is_completed
        }
      ];
    case 'TOGGLE_COMPLETED':
      return state.map(todo => {
        if (todo.id != action.id) {
          return todo;
        }

        if (Object.keys(action.payload).length === 0) {
          return {
            ...todo,
            completed: !todo.completed
          }
        }

        return {
          ...todo,
          completed: action.payload.data.data[0].attributes.is_completed
        }
      });
    case 'RESET_TODO':
      return [];
    case 'POPULATE_TODOS':
      var todos = action.payload.data.data;
      var items = [];
      for (var i = 0; i < todos.length; i++) {
        items.push({
          id: todos[i].attributes.uid,
          text: todos[i].attributes.title,
          completed: todos[i].attributes.is_completed
        });
      }
      return items;
    default:
      return state
  }
};

export default todos;