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
use Illuminate\Support\Facades\Hash;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

/**
 * Class OAuthRepository
 *
 * Authorization Server with Password Grant.
 *
 * @see https://github.com/lucadegasperi/oauth2-server-laravel
 */
class OAuthRepository
{
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
        if ($request->get('scope') !== 'role.app') {
            throw new OAuthException('Invalid scope provided', 40001001);
        }

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
        if ($request->get('scope') !== 'role.user') {
            throw new OAuthException('Invalid scope provided', 40001001);
        }

        return $this->issueAccessToken();
    }

    /**
     * Refresh user access token
     *
     * @return array
     * @throws OAuthException
     */
    public function refreshUserAccessToken()
    {
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

        if ($user && Hash::check($password, $user->password)) {
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
        return Authorizer::issueAccessToken();
    }
}
