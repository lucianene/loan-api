<?php

/**
 * Bind services into the container
 */
return [
    'container' => LoanApi\Core\DependencyInjection\Container::class,
    'request' => LoanApi\Core\Http\Request::class,
    'router' => LoanApi\Core\Router\Router::class,
    'database' => LoanApi\Core\Database\Database::class,
    'repositories.loan' => LoanApi\Repositories\LoanRepository::class,
    'amortization' => LoanApi\Amortization::class,
];
