<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->resource('auth');
$routes->post('auth/update/(:num)', 'Auth::update/$1');
//$routes->get('auth/ambildata', 'Auth::ambildata');
$routes->resource('maplikasi');
$routes->resource('aksesaplikasi');
$routes->post('jwt', 'jwt::index');

