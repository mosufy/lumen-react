<?php
/**
 * Class AccountController
 *
 * @date      28/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Http\Controllers;

use App\Helpers\IPAddressHelper;
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
}
