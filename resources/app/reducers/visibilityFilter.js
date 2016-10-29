/**
 * visibilityFilter.js
 *
 * A reducer takes an existing state, executes the action and returns the new state.
 *
 * @date 23/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

const visibilityFilter = (state = 'SHOW_ALL', action) => {
  switch (action.type) {
    case 'SET_VISIBILITY_FILTER':
      return action.filter;
    default:
      return state
  }
};

export default visibilityFilter;
