<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Authentication::index');
$routes->get('/user', 'User::index');
$routes->get('/user/recent', 'User::recent');
