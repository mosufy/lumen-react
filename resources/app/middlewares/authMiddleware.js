/**
 * authMiddleware
 *
 * @date 25/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

const authMiddleware = store => next => action => {
  if (action.type === 'AUTH_AUTHENTICATE_USER') {
    return next(action);
  }
  //do stuff!
};