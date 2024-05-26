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
$routes->get('/user/upload', 'User::upload', ['filter' => 'auth:user']);
$routes->get('/user/trash', 'User::trash', ['filter' => 'auth:user']);
$routes->get('/user/trash/emptyTrash', 'User::emptyTrash', ['filter' => 'auth:user']);

// Folder
$routes->post('/user/createFolder', 'Folder::addFolder', ['filter' => 'auth:user']);
$routes->post('/user/folder/rename', 'Folder::renameFolder', ['filter' => 'auth:user']);
$routes->post('/user/folder/moveToTrash', 'Folder::moveToTrash', ['filter' => 'auth:user']);
$routes->post('/user/folder/restoreFolder', 'Folder::restoreFolder', ['filter' => 'auth:user']);
$routes->post('/user/folder/deleteFolder', 'Folder::deleteFolder', ['filter' => 'auth:user']);

// Files
$routes->post('/user/addFiles', 'File::addFile', ['filter' => 'auth:user']);
$routes->post('/user/file/rename', 'File::renameFile', ['filter' => 'auth:user']);
$routes->post('/user/file/moveToTrash', 'File::moveToTrash', ['filter' => 'auth:user']);
$routes->post('/user/file/restoreFile', 'File::restoreFile', ['filter' => 'auth:user']);
$routes->post('/user/file/deleteFile', 'File::deleteFile', ['filter' => 'auth:user']);

// Admin
$routes->get('/admin', 'admin::index', ['filter' => 'auth:admin']);
$routes->post('/admin/register', 'admin::register', ['filter' => 'auth:admin']);
$routes->post('/admin/changeRole', 'admin::changeRole', ['filter' => 'auth:admin']);
$routes->post('/admin/deleteUser', 'admin::deleteUser', ['filter' => 'auth:admin']);
$routes->post('/admin/addUsersFromExcel', 'admin::addUsersFromExcel', ['filter' => 'auth:admin']);
