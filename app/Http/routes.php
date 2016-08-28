<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->group(['prefix' => 'v1'], function () use ($app) {
    $app->get('/', ['as' => 'services.index', 'uses' => '\App\Http\Controllers\ServiceController@ping']);
    $app->get('/services/ping', ['as' => 'services.ping', 'uses' => '\App\Http\Controllers\ServiceController@ping']);
});

$app->get('/', ['as' => 'home.index', 'uses' => 'ServiceController@ping']);
