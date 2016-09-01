<?php
/**
 * Class OAuthController
 *
 * @date      28/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Http\Controllers;

use App\Exceptions\OAuthException;
use App\Repositories\OAuthRepository;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

/**
 * Class OAuthController
 *
 * OAuth2 endpoints
 */
class OAuthController extends Controller
{
    use ResponseTrait;

    protected $oauthRepository;

    public function __construct(OAuthRepository $oauthRepository)
    {
        $this->oauthRepository = $oauthRepository;
    }

    /**
     * Generate client access token
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function clientAccessToken(Request $request)
    {
            return response()->json($this->oauthRepository->issueClientAccessToken($request));
    }

    /**
     * Generate or refresh user access token
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function accessToken(Request $request)
    {
        return response()->json($this->oauthRepository->issueUserAccessToken($request));
    }
}
