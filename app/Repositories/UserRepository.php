<?php
/**
 * Class UserRepository
 *
 * @date      30/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Repositories;

use App\Exceptions\UserException;
use App\Models\AppLog;
use App\Models\User;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

/**
 * Class UserRepository
 *
 * User resources.
 */
class UserRepository
{
    /**
     * Get User by resource owner id
     *
     * @return User
     */
    public function getUserByResourceOwnerId()
    {
        $user_id = Authorizer::getResourceOwnerId();
        return $this->getUser($user_id);
    }

    /**
     * Get User by uid
     *
     * @param string $user_uid
     * @return User
     */
    public function getUserByUid($user_uid)
    {
        return $this->getUser($user_uid);
    }

    /**
     * Get User by users.id or users.uid
     *
     * @param int|string $identifier
     * @return User
     * @throws UserException
     */
    public function getUser($identifier)
    {
        if (filter_var($identifier, FILTER_VALIDATE_INT) !== false) {
            $user = User::find($identifier);
        } else {
            $user = User::where('uid', $identifier)->first();
        }

        if (!empty($user)) {
            return $user;
        }

        AppLog::warning(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
            'User not found', [
            'identifier' => $identifier
        ]);

        throw new UserException('User not found', 40401001);
    }
}
