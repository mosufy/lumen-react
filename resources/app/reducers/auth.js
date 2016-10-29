/**
 * auth
 *
 * @date 25/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import {addTime} from './../helpers/helperFunctions';

let initialState = {
  isAuthenticated: false,
  clientAccessToken: '',
  clientTokenExpiresAt: '',
  accessToken: '',
  tokenExpiresAt: '',
  refreshToken: ''
};

const auth = (state = initialState, action) => {
  switch (action.type) {
    case 'SAVE_CLIENT_ACCESS_TOKEN':
      return {
        ...state,
        clientAccessToken: action.payload.data.access_token,
        clientTokenExpiresAt: addTime(action.payload.data.expires_in)
      };
    case 'SAVE_ACCESS_TOKEN':
      return {
        ...state,
        isAuthenticated: true,
        accessToken: action.payload.data.access_token,
        tokenExpiresAt: addTime(action.payload.data.expires_in),
        refreshToken: action.payload.data.refresh_token
      };
    case 'RESET_ACCESS_TOKEN':
      return initialState;
    default:
      return state
  }
};

export default auth;