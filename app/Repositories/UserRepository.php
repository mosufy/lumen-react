<?php
/**
 * Class UserRepository
 *
 * @date      30/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Repositories;

use App\Events\UserCreated;
use App\Exceptions\UserException;
use App\Models\AppLog;
use App\Models\User;
use Illuminate\Contracts\Hashing\Hasher;
use Illuminate\Database\QueryException;
use LucaDegasperi\OAuth2Server\Authorizer;
use Ramsey\Uuid\Uuid;

/**
 * Class UserRepository
 *
 * User resources.
 */
class UserRepository
{
    protected $hash;

    public function __construct(Hasher $hash)
    {
        $this->hash = $hash;
    }

    /**
     * Get User by resource owner id
     *
     * @return User
     */
    public function getUserByResourceOwnerId()
    {
        $user_id = $this->getAuthorizer()->getResourceOwnerId();
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

    /**
     * Get current user requesting resource
     *
     * @return User
     */
    public function getCurrentUser()
    {
        return User::find($this->getCurrentUserId());
    }

    /**
     * Get current user id requesting the resource
     *
     * @return int
     */
    public function getCurrentUserId()
    {
        return $this->getAuthorizer()->getResourceOwnerId();
    }

    /**
     * Create user account
     *
     * @param array $params
     * @return User
     * @throws UserException
     */
    public function createUser($params)
    {
        try {
            $user           = new User;
            $user->uid      = Uuid::uuid4()->toString();
            $user->email    = $params['email'];
            $user->password = $this->hash->make($params['password']);
            $user->name     = $params['name'];
            $user->save();

            event(new UserCreated($user));

            return $user;
        } catch (QueryException $e) {
            AppLog::warning(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                get_class($e), [
                'message' => $e->getMessage(),
                'code'    => $e->getCode(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'params'  => $params
            ]);

            if ($e->getCode() == 23000) {
                // Integrity constraint violation: 1062 Duplicate entry
                throw new UserException('Email already exist. Please try a different email', 40000000);
            }

            throw new UserException('Exception thrown while trying to create user', 50001001); // @codeCoverageIgnore
        } catch (\Exception $e) { // @codeCoverageIgnoreStart
            AppLog::error(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                get_class($e), [
                'message' => $e->getMessage(),
                'code'    => $e->getCode(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine(),
                'params'  => $params
            ]);
            throw new UserException('Exception thrown while trying to create user', 50001001);
        } // @codeCoverageIgnoreEnd
    }

    /**
     * Get the OAuth2 authorizer
     *
     * @return Authorizer
     */
    protected function getAuthorizer()
    {
        return app(Authorizer::class);
    }
}
