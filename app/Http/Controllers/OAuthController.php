<?php
/**
 * Class OAuthController
 *
 * @date      28/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Http\Controllers;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;

/**
 * Class OAuthController
 *
 * OAuth2 endpoints
 */
class OAuthController extends Controller
{
    /**
     * Validate user credentials in exchange of access_token
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function accessToken()
    {
        return response()->json(Authorizer::issueAccessToken());
    }
}
