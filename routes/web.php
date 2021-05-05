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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group([
    'prefix' => 'api'
], function () use ($router) {

    $router->group([
        'prefix' => 'auth'
    ], function () use ($router) {
    
        $router->post('register', 'AuthController@register');
        $router->post('login', 'AuthController@login');
        $router->post('logout', 'AuthController@logout');
        $router->post('refresh', 'AuthController@refresh');
        
    });
    
});

$router->group([
    'middleware' => 'auth',
    'prefix' => 'api'
], function () use ($router) {
    $router->get('/location', 'LocationController@index');
    $router->post('/location', 'LocationController@store');
    $router->get('/location/{id}', 'LocationController@show');
    $router->patch('/location/{id}', 'LocationController@update');
    $router->delete('/location/{id}', 'LocationController@destroy');

    $router->get('/inventoryitem', 'InventoryItemController@index');
    $router->post('/inventoryitem', 'InventoryItemController@store');
    $router->get('/inventoryitem/{id}', 'InventoryItemController@show');
    $router->patch('/inventoryitem/{id}', 'InventoryItemController@update');
    $router->delete('/inventoryitem/{id}', 'InventoryItemController@destroy');

    $router->get('/book', 'BookController@index');
    $router->post('/book', 'BookController@store');
    $router->get('/book/{id}', 'BookController@show');
    $router->patch('/book/{id}', 'BookController@update');
    $router->delete('/book/{id}', 'BookController@destroy');
});
