/**
 * auth
 *
 * @date 28/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import * as sdk from './../helpers/sdk';
import {updateLoader} from './commonActions';

export const saveClientAccessToken = (payload) => {
  return {
    type: 'SAVE_CLIENT_ACCESS_TOKEN',
    payload
  }
};

export const saveAccessToken = (payload) => {
  return {
    type: 'SAVE_ACCESS_TOKEN',
    payload
  }
};

export const resetAccessToken = () => {
  return {
    type: 'RESET_ACCESS_TOKEN'
  }
};

export const login = (email, password) => {
  return (dispatch, getState) => {
    dispatch(updateLoader(0.5));
    return sdk.generateUserAccessToken(getState().auth.clientAccessToken, email, password)
      .then((response) => {
        dispatch(saveAccessToken(response));
        dispatch(updateLoader(1));
      })
      .catch(function (error) {
        dispatch(updateLoader(1));
        console.log('Failed to generate user access token');
        console.log(error);
      });
  }
};

export const signup = (email, password, name) => {
  return (dispatch, getState) => {
    dispatch(updateLoader(0.25));
    return sdk.signup(getState().auth.clientAccessToken, email, password, name)
      .then(() => {
        return dispatch(login(email, password));
      })
      .catch(function (error) {
        dispatch(updateLoader(1));
        console.log('Failed to sign up user');
        console.log(error);
      });
  }
};

export const generateClientAccessToken = () => {
  return (dispatch) => {
    return sdk.generateClientAccessToken()
      .then((response) => {
        dispatch(saveClientAccessToken(response));
      })
      .catch(function (error) {
        console.log('Failed generating client access token');
        console.log(error);
      })
  }
};

export const refreshToken = () => {
  return (dispatch) => {
    return sdk.refreshToken(getState().auth.clientAccessToken, getState().auth.refreshToken)
      .then((response) => {
        dispatch(saveAccessToken(response));
      })
      .catch(function (error) {
        console.log('Failed refreshing access token. Please try again');
        console.log(error);
      })
  }
};