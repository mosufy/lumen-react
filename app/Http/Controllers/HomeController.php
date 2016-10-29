<?php
/**
 * Class HomeController
 *
 * @date      21/9/2016
 * @author    Mosufy <mosufy@gmail.com>
 * @copyright Copyright (c) Mosufy
 */

namespace App\Http\Controllers;

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
            $jsonBundle = json_decode(file_get_contents(base_path('webpack.' . app()->environment() . '.manifest.json')), true);
            $bundleJS   = $jsonBundle['bundle']['js'];

            $jsonDll = json_decode(file_get_contents(base_path('webpack.dll.manifest.json')), true);
            $dllJS   = $jsonDll['vendor']['js'];
        } catch (\Exception $e) {
            $bundleJS = 'bundle.js';
            $dllJS    = 'dll.vendor.js';
        }

        return view('index', [
            'bundleJS' => $bundleJS,
            'dllJS'    => $dllJS
        ]);
    }
}
