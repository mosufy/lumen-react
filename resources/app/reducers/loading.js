/**
 * loader
 *
 * @date 27/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

const loading = (state = {progress: 1.0, completed: true}, action) => {
  switch (action.type) {
    case 'UPDATE_LOADER':
      if (action.progress >= 1) {
        return {
          progress: action.progress,
          completed: true
        };
      }

      return {
          progress: action.progress,
          completed: false
        };
    default:
      return state
  }
};

export default loading;