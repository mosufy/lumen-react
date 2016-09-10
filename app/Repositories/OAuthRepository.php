<?php
/**
 * Class OAuthRepository
 *
 * @date      28/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Repositories;

use App\Exceptions\OAuthException;
use App\Models\User;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Authorizer;
use Illuminate\Contracts\Hashing\Hasher;

/**
 * Class OAuthRepository
 *
 * Authorization Server.
 *
 * @see https://github.com/lucadegasperi/oauth2-server-laravel
 */
class OAuthRepository
{
    protected $hash;

    public function __construct(Hasher $hash)
    {
        $this->hash = $hash;
    }

    /**
     * Issue client access token
     *
     * Checks if scope requested is allowed.
     *
     * @param Request $request
     * @return array
     * @throws OAuthException
     */
    public function issueClientAccessToken($request)
    {
        // Overwrite the scope to use pre-defined scope
        $request->merge(['scope' => 'role.app']);
        return $this->issueAccessToken();
    }

    /**
     * Issue user access token
     *
     * Checks if scope requested is allowed.
     *
     * @param Request $request
     * @return array
     * @throws OAuthException
     */
    public function issueUserAccessToken($request)
    {
        // Overwrite the scope to use pre-defined scope
        $request->merge(['scope' => 'role.user']);
        return $this->issueAccessToken();
    }

    /**
     * Verify user credentials via Password Grant callback
     *
     * @param string $mail
     * @param string $password
     * @return bool
     *
     * @see https://github.com/lucadegasperi/oauth2-server-laravel/blob/master/docs/authorization-server/choosing-grant.md#resource-owner-credentials-grant-section-43
     */
    public function passwordGrantVerify($mail, $password)
    {
        $user = User::where('email', $mail)->first();

        if ($user && $this->hash->check($password, $user->password)) {
            return $user->id;
        }

        return false;
    }

    /**
     * Issue access token
     *
     * @return array
     */
    protected function issueAccessToken()
    {
        $authorizer = app(Authorizer::class);
        return $authorizer->issueAccessToken();
    }
}
