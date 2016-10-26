/**
 * sdk
 *
 * SDK to connect to API.
 *
 * @date 25/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import Constant from './../helpers/constant';
import axios from 'axios';

const config = (clientAccessToken = '') => {
  return ({
    headers: {'Authorization': 'Bearer ' + clientAccessToken}
  });
};

export function generateClientAccessToken() {
  return axios.post(Constant.apiUrl + '/oauth/access_token/client', {
    grant_type: 'client_credentials',
    client_id: Constant.clientId,
    client_secret: Constant.clientSecret,
    scope: 'role.app'
  });
}

export function generateUserAccessToken(clientAccessToken, username, password) {
  return axios.post(Constant.apiUrl + '/oauth/access_token', {
    grant_type: 'password',
    client_id: Constant.clientId,
    client_secret: Constant.clientSecret,
    username,
    password,
    scope: 'role.user'
  }, config(clientAccessToken));
}