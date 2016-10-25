/**
 * auth
 *
 * @date 25/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

let initialState = {
  isAuthenticated: false
};

const auth = (state = initialState, action) => {
  switch (action.type) {
    case 'AUTH_LOGIN_USER':
      return {
        isAuthenticated: false
      };
    case 'AUTH_AUTHENTICATED':
      return {
        isAuthenticated: false
      };
    default:
      return state
  }
};

export default auth;