/**
 * helperFunctions
 *
 * @date 26/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

/**
 * Add seconds to current timestamp
 *
 * @param seconds
 * @returns {number}
 */
export const addTime = (seconds) => {
  return Date.now() + (seconds * 1000);
};