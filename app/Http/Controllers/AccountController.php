<?php
/**
 * Class AccountController
 *
 * @date      28/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class AccountController
 *
 * Own account controller endpoints.
 */
class AccountController extends Controller
{
    /**
     * Fetch own account details
     *
     * This resource should only be restricted to the actual owner of the account.
     *
     * @param Request $request
     * @param string $user_uid
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(Request $request, $user_uid)
    {
        return $this->responseSuccess('user', []);
    }
}
