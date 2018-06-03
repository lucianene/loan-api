<?php

use LoanApi\Core\DependencyInjection\Container;

ini_set('display_errors', 'On');
error_reporting(E_ALL);

// load helpers and the namespace loader
require_once __DIR__ . '/helpers.php';
require_once __DIR__ . '/loader.php';

// register namespaces
register_namespace('LoanApi\\Core\\', '/core/');
register_namespace('LoanApi\\Controllers\\', '/controllers/');
register_namespace('LoanApi\\Repositories\\', '/repositories/');
register_namespace('LoanApi\\', '/app/');

// instantiate only the container and the router
// bind services into the container
$container = new Container(config_dir('/services.php'));

// register a router and dispatch the current request
$router = $container->get('router');
$router->dispatch();
