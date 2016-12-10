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
    $app->post('/oauth/access_token', ['as' => 'oauth.accessToken', 'uses' => 'OAuthController@accessToken']);

    // user resource endpoint
    $app->post('/account', ['as' => 'account.store', 'uses' => 'AccountController@store']);
});

$app->group(['prefix' => 'v1', 'middleware' => 'oauth:role.user'], function () use ($app) {
    $app->get('/account', ['as' => 'account.index', 'uses' => 'AccountController@index']);

    // to-do resource endpoints
    $app->get('/todos[{param}]', ['as' => 'todo.index', 'uses' => 'TodoController@index']);
    $app->get('/todos/{todo_uid}', ['as' => 'todo.show', 'uses' => 'TodoController@show']);
    $app->post('/todos', ['as' => 'todo.store', 'uses' => 'TodoController@store']);
    $app->put('/todos/{todo_uid}/toggle', ['as' => 'todo.toggle', 'uses' => 'TodoController@toggle']);
    $app->put('/todos/{todo_uid}', ['as' => 'todo.update', 'uses' => 'TodoController@update']);
    $app->delete('/todos', ['as' => 'todo.destroyAll', 'uses' => 'TodoController@destroyAll']);
    $app->delete('/todos/{todo_uid}', ['as' => 'todo.destroy', 'uses' => 'TodoController@destroy']);
});

// ReactJS Single Page Application
$app->get('/', ['as' => 'home.index', 'uses' => 'HomeController@index']);
$app->get('/{sap:.+}', ['as' => 'home.indexSAP', 'uses' => 'HomeController@index']);
