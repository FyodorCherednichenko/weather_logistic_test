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

use App\Http\Controllers\Controller;

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/city-weather', [
    'as' => 'city-weather',
    'uses' => 'Controller@cityWeather'
]);

$router->get('/schedule/{date}/{time}/{direction}', [
    'as' => 'schedule',
    'uses' => 'Controller@schedule'
]);
