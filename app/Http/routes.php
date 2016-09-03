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

$app->get('/v1/services/ping', ['as' => 'services.ping', 'uses' => 'ServiceController@ping']);
$app->post('/v1/oauth/access_token/client', ['as' => 'oauth.clientAccessToken', 'uses' => 'OAuthController@clientAccessToken']);

$app->group(['prefix' => 'v1', 'middleware' => 'oauth:role.app'], function () use ($app) {
    $app->post('/oauth/access_token', ['as' => 'oauth.accessToken', 'uses' => '\App\Http\Controllers\OAuthController@accessToken']);

    // user resource endpoint
    $app->post('/account', ['as' => 'account.store', 'uses' => '\App\Http\Controllers\AccountController@store']);
});

$app->group(['prefix' => 'v1', 'middleware' => 'oauth:role.user'], function () use ($app) {
    $app->get('/account', ['as' => 'account.index', 'uses' => '\App\Http\Controllers\AccountController@index']);
});
