<?php

return [
    'request' => LoanApi\Core\Http\Request::class,
    'router' => LoanApi\Core\Router\Router::class,
    'repositories.loan' => LoanApi\Repositories\LoanRepository::class,
];
