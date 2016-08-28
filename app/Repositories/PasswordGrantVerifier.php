<?php
/**
 * Class PasswordGrantVerifier
 *
 * @date      28/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

/**
 * Class PasswordGrantVerifier
 *
 * Authorization Server with Password Grant
 *
 * @see https://github.com/lucadegasperi/oauth2-server-laravel/blob/master/docs/authorization-server/choosing-grant.md#resource-owner-credentials-grant-section-43
 */
class PasswordGrantVerifier
{
    public function verify($username, $password)
    {
        $user = User::where('email', $username)->first();

        if ($user && Hash::check($password, $user->password)) {
            return $user->id;
        }

        return false;
    }
}
