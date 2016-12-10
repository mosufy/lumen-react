/**
 * sdk
 *
 * SDK to connect to API.
 *
 * @date 25/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import axios from 'axios';

const apiHost = process.env.API_HOST || 'https://lumen-react.local/v1';
const apiClientId = process.env.API_CLIENT_ID || '6fC2745co07D4yW7X9saRHpJcE0sm0MT';
const apiClientSecret = process.env.API_CLIENT_SECRET || 'KLqMw5D7g1c6KX23I72hx5ri9d16GJDW';

const config = (accessToken = '') => {
  return ({
    headers: {'Authorization': 'Bearer ' + accessToken}
  });
};

/**
 * Generate client access token
 *
 * @returns AxiosPromise
 */
export function generateClientAccessToken() {
  return axios.post(apiHost + '/oauth/access_token/client', {
    grant_type: 'client_credentials',
    client_id: apiClientId,
    client_secret: apiClientSecret,
    scope: 'role.app'
  });
}

/**
 * Generate user access token
 *
 * @param clientAccessToken
 * @param username
 * @param password
 * @returns AxiosPromise
 */
export function generateUserAccessToken(clientAccessToken, username, password) {
  return axios.post(apiHost + '/oauth/access_token', {
    grant_type: 'password',
    client_id: apiClientId,
    client_secret: apiClientSecret,
    username,
    password,
    scope: 'role.user'
  }, config(clientAccessToken));
}

/**
 * Signup
 *
 * @param clientAccessToken
 * @param email
 * @param password
 * @param name
 * @returns AxiosPromise
 */
export function signup(clientAccessToken, email, password, name) {
  return axios.post(apiHost + '/account', {
    email,
    password,
    name
  }, config(clientAccessToken));
}

/**
 * Get user data
 *
 * @param accessToken
 * @returns AxiosPromise
 */
export function getUserData(accessToken) {
  return axios.get(apiHost + '/account', config(accessToken));
}

/**
 * Refresh existing user access token
 *
 * @param clientAccessToken
 * @param refreshToken
 * @returns AxiosPromise
 */
export function refreshToken(clientAccessToken, refreshToken) {
  return axios.post(apiHost + '/oauth/access_token', {
    grant_type: 'refresh_token',
    client_id: apiClientId,
    client_secret: apiClientSecret,
    refresh_token: refreshToken
  }, config(clientAccessToken));
}

export function getTodos(accessToken) {
  return axios.get(apiHost + '/todos', config(accessToken));
}

export function insertTodo(accessToken, text) {
  return axios.post(apiHost + '/todos', {
    title: text
  }, config(accessToken));
}

export function toggleTodo(accessToken, id) {
  return axios.put(apiHost + '/todos/' + id + '/toggle', null, config(accessToken));
}

export function deleteAllTodos(accessToken) {
  return axios.delete(apiHost + '/todos', config(accessToken));
}