/**
 * auth
 *
 * @date 25/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

let initialState = {
  isAuthenticated: false,
  clientAccessToken: '',
  clientTokenExpiresIn: '',
  accessToken: '',
  tokenExpiresIn: '',
  refreshToken: ''
};

const auth = (state = initialState, action) => {
  switch (action.type) {
    case 'AUTH_CLIENT_TOKEN':
      return {
        ...state,
        clientAccessToken: action.payload.data.access_token,
        clientTokenExpiresIn: action.payload.data.expires_in
      };
    case 'AUTH_USER_TOKEN':
      return {
        ...state,
        isAuthenticated: true,
        accessToken: action.payload.data.access_token,
        tokenExpiresIn: action.payload.data.expires_in,
        refreshToken: action.payload.data.refresh_token
      };
    default:
      return state
  }
};

export default auth;