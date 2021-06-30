<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('account', [
    'as' => 'account',
    'uses' => 'Controller@account',
]);

$router->get('order/{order}', [
    'as' => 'order',
    'uses' => 'Controller@order',
]);

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('order/{order}/close', ['uses' => 'Controller@close']);
    $router->post('buy', ['uses' => 'Controller@buy']);
    $router->post('sell', ['uses' => 'Controller@sell']);
});
