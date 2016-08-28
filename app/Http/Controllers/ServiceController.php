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
        try {
            AppLog::info(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                'This is a log', [
                'timestamp' => Carbon::now()
            ]);
            return $this->responseSuccess('timestamp', ['timestamp' => Carbon::now()]);
        } catch (\Exception $e) {
            return $this->responseError('Oops... Something went wrong', $e->getMessage(), $e->getCode());
        }
    }
}
