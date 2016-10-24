/**
 * auth
 *
 * @date 25/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

const auth = (state = 'NOT_LOGGED_IN', action) => {
  switch (action.type) {
    case 'AUTH_LOGIN_USER':
      return 'LOGGED_IN';
    default:
      return state
  }
};

export default auth;