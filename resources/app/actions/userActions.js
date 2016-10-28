/**
 * user
 *
 * @date 28/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

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