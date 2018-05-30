<?php

namespace LoanApi\Controllers;

use LoanApi\Core\DependencyInjection\Container;
use LoanApi\Core\Http\Request;
use LoanApi\Core\Http\Response;

class ApiController
{
    public function jsonResponse($data)
    {
        echo (new Response($data))->toJson();
        return;
    }
}
