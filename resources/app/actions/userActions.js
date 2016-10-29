/**
 * user
 *
 * @date 28/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

import * as sdk from './../helpers/sdk';

export const saveUserData = (payload) => {
  return {
    type: 'SAVE_USER_DATA',
    payload
  }
};

export const removeUserData = () => {
  return {
    type: 'REMOVE_USER_DATA'
  }
};

export const getUserData = () => {
  return (dispatch, getState) => {
    return sdk.getUserData(getState().auth.accessToken)
      .then((response) => {
        dispatch(saveUserData(response));
      })
      .catch(function (error) {
        console.log('Failed fetching user data');
        console.log(error);
      })
  }
};