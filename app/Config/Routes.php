<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'Home::index');

// Define routes for UserController
$routes->group('api/users', ['namespace' => 'App\Controllers'], function(RouteCollection $routes) {
    $routes->get('/', 'UserController::index');
    $routes->get('(:num)', 'UserController::show/$1');
    $routes->post('create', 'UserController::create');
    $routes->put('update/(:num)', 'UserController::update/$1');
    $routes->delete('delete/(:num)', 'UserController::delete/$1');
});
