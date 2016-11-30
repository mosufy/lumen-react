<?php
/**
 * Class HomeController
 *
 * @date      21/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Http\Controllers;
use App\Models\AppLog;

/**
 * Class HomeController
 *
 * Placeholder for reactjs routes.
 */
class HomeController
{
    /**
     * Return homepage
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        try {
            // Get the correct hashed bundle JS file
            // TODO: Find a better way to fetch hash bundle.js
            $jsonBundle = json_decode(file_get_contents(base_path('webpack/webpack.' . app()->environment() . '.manifest.json')), true);
            $bundleJS   = $jsonBundle['bundle']['js'];

            $jsonDll = json_decode(file_get_contents(base_path('webpack/webpack.dll.manifest.json')), true);
            $dllJS   = $jsonDll['vendor']['js'];
        } catch (\Exception $e) {
            AppLog::warning(__CLASS__ . ':' . __TRAIT__ . ':' . __FUNCTION__ . ':' . __FILE__ . ':' . __LINE__ . ':' .
                'Unable to fetch the correct bundle.js from HomeController. Using production bundle', [
                'message' => $e->getMessage(),
                'code'    => $e->getCode(),
                'file'    => $e->getFile(),
                'line'    => $e->getLine()
            ]);
            $bundleJS = 'bundle.js';
            $dllJS    = 'dll.vendor.js';
        }

        return view('index', [
            'bundleJS' => $bundleJS,
            'dllJS'    => $dllJS
        ]);
    }
}
