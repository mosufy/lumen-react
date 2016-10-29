/**
 * commonActions
 *
 * @date 28/10/2016
 * @author Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

export const updateLoader = (progress) => {
  return {
    type: 'UPDATE_LOADER',
    progress
  }
};