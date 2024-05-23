<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Authentication
$routes->get('/', 'Authentication::index');
$routes->post('/login', 'Authentication::loginProcess');
$routes->get('/logout', 'Authentication::logout');

// User
$routes->get('/user', 'User::index', ['filter' => 'auth:user']);
$routes->get('/user/recent', 'User::recent', ['filter' => 'auth:user']);
$routes->get('/user/upload', 'User::upload', ['filter' => 'auth:user']);
$routes->get('/user/trash', 'User::trash', ['filter' => 'auth:user']);

// Admin
$routes->get('/admin', 'admin::index', ['filter' => 'auth:admin']);
$routes->post('/admin/register', 'admin::register', ['filter' => 'auth:admin']);
$routes->post('/admin/changeRole', 'admin::changeRole', ['filter' => 'auth:admin']);
$routes->post('/admin/deleteUser', 'admin::deleteUser', ['filter' => 'auth:admin']);
$routes->post('/admin/addUsersFromExcel', 'admin::addUsersFromExcel', ['filter' => 'auth:admin']);
