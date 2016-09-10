<?php
/**
 * Class AccountController
 *
 * @date      28/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Http\Controllers;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;

/**
 * Class AccountController
 *
 * Own account controller endpoints.
 */
class AccountController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Fetch own account details
     *
     * This resource should only be restricted to the actual owner of the account.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {
        return $this->responseSuccess('user', $this->userRepository->getUserByResourceOwnerId());
    }

    /**
     * Create new user account
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request)
    {
        try {
            $user = $this->userRepository->createUser($request->all());
            return $this->responseSuccess('user', $user);
        } catch (\Exception $e) {
            return $this->responseError('Failed to create user', $e->getMessage(), $e->getCode());
        }
    }
}
