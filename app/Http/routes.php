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

$app->post('/v1/oauth/client_access_token', ['as' => 'oauth.clientAccessToken', 'uses' => 'OAuthController@accessToken']);

$app->group(['prefix' => 'v1', 'middleware' => 'oauth:role.app'], function () use ($app) {
    $app->get('/services/ping', ['as' => 'services.ping', 'uses' => '\App\Http\Controllers\ServiceController@ping']);
    $app->post('/oauth/access_token', ['as' => 'oauth.accessToken', 'uses' => '\App\Http\Controllers\OAuthController@accessToken']);
});

$app->group(['prefix' => 'v1', 'middleware' => 'oauth:role.user'], function () use ($app) {
    $app->get('/account', ['as' => 'account.index', 'uses' => '\App\Http\Controllers\AccountController@index']);
});
