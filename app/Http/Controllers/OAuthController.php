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
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

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
        try {
            return $this->responseSuccess('oauth2', $this->oauthRepository->issueClientAccessToken($request));
        } catch (OAuthException $e) {
            return $this->responseError('Failed to generate access token', $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Generate user access token
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function accessToken(Request $request)
    {
        try {
            return $this->responseSuccess('oauth2', $this->oauthRepository->issueUserAccessToken($request));
        } catch (OAuthException $e) {
            return $this->responseError('Failed to generate access token', $e->getMessage(), $e->getCode());
        }
    }

    /**
     * Refresh user access token
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function refreshToken()
    {
        try {
            return $this->responseSuccess('oauth2', $this->oauthRepository->refreshUserAccessToken());
        } catch (OAuthException $e) {
            return $this->responseError('Failed to refresh access token', $e->getMessage(), $e->getCode());
        }
    }
}
