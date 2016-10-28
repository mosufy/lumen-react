/**
 * user
 *
 * @date 28/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

const user = (state = {}, action) => {
  switch (action.type) {
    case 'SAVE_USER_DATA':
      return {
        id: action.payload.data.data[0].attributes.uid,
        name: action.payload.data.data[0].attributes.name
      };
    case 'REMOVE_USER_DATA':
      return {};
    default:
      return state
  }
};

export default user;