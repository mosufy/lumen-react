<?php
/**
 * Class ServiceController
 *
 * @date      26/8/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Http\Controllers;

use App\Models\AppLog;
use Carbon\Carbon;

/**
 * Class ServiceController
 *
 * Services related endpoints
 */
class ServiceController extends Controller
{
    /**
     * Ping Test
     *
     * @return mixed
     */
    public function ping()
    {
        return $this->responseSuccess('timestamp', ['timestamp' => Carbon::now()]);
    }
}
