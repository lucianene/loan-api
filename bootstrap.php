<?php

// define constants
define('__CONFIG_DIR__', __DIR__ . '/config');
define('__CORE_DIR__', __DIR__ . '/core');
define('__ROUTES_DIR__', __DIR__ . '/routes');
define('__CONTROLLERS_DIR__', __DIR__ . '/controllers');

// register namespaces
$loader = require_once __DIR__ . '/autoload.php';
$loader->add('LoanApi\\Core\\', '/core/');
$loader->add('LoanApi\\Controllers\\', '/controllers/');
$loader->add('LoanApi\\Repositories\\', '/repositories/');
$loader->make();

// instantiate only the container and the router
// bind services into the container
$container = new LoanApi\Core\DependencyInjection\Container(__CONFIG_DIR__ . '/services.php');
$request = $container->get('request')->handle($_SERVER);

// die(var_dump($container));

// register a router and dispatch
$router = $container->get('router');
$router->dispatch($request);

// die(var_dump($_SERVER['REQUEST_METHOD']));
// die(var_dump($router->getRoutes()));
