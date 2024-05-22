<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Authentication::index');
$routes->get('/user', 'User::index');
$routes->get('/user/recent', 'User::recent');
$routes->get('/user/upload', 'User::upload');
$routes->get('/user/trash', 'User::trash');
$routes->get('/admin', 'admin::index');
$routes->post('/admin/register', 'admin::register');
$routes->post('/admin/changeRole', 'admin::changeRole');
