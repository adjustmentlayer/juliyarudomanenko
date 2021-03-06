<?php

/**
 * Front controller
 *
 * PHP version 7.0
 */

/**
 * Composer
 */
require dirname(__DIR__) . '/vendor/autoload.php';
/**
 * Sessions
 */
session_start();

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');


/**
 * Routing
 */
$router = new Core\Router();

// Add the routes
$router->add('admin/login', ['controller' => 'Login', 'action' => 'index','namespace' => 'Admin']);
$router->add('admin/logout', ['controller' => 'Login', 'action' => 'destroy','namespace' => 'Admin']);
$router->add('admin', ['controller' => 'Home', 'action' => 'index', 'namespace' => 'Admin']);

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{id:[a-z0-9-]+}', ['controller' => 'Blog', 'action' => 'show']);


$router->add('admin/{controller}/{action}',['namespace' => 'Admin']);
$router->add('admin/{controller}/{id:[\d]+}/{action}',['namespace' => 'Admin']);
$router->add('admin/{controller}/{id:[\d]+}/{action}/{page:[\d]+}',['namespace' => 'Admin']);
$router->add('admin/{controller}/{action}/{page:[\d]+}',['namespace' => 'Admin']);

$router->add('{controller}/{id:[a-z0-9-]+}/{action}');
$router->add('{controller}/{action}');
$router->add('{controller}/{action}/{page:[\d]+}');







    
$router->dispatch($_SERVER['QUERY_STRING']);
