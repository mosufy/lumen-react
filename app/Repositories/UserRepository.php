<?php
/**
 * Class UserRepository
 *
 * @date      30/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Repositories;

use App\Models\User;

/**
 * Class UserRepository
 *
 * User resources.
 */
class UserRepository
{
    /**
     * Get User data by user_uid
     *
     * @param string $user_uid
     * @return User
     */
    public function getUserByUid($user_uid)
    {
        $user = User::where('uid', $user_uid)->first();

        return $user;
    }
}
