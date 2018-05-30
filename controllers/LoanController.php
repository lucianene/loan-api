<?php

namespace LoanApi\Controllers;

use LoanApi\Core\Http\Request;
use LoanApi\Core\Http\Response;
use LoanApi\Core\Router\Controller as BaseController;
use LoanApi\Repositories\LoanRepository;

class LoanController extends BaseController
{
    public function index()
    {
        $loanRepository = $this->container->get('repositories.loan');
        $request = $this->container->get('request');
        $data = $loanRepository->all();

        return (new Response($data, 404))->jsonResponse();
    }

    public function create() {}

    public function store() {
        echo 'put method executed' . PHP_EOL;
    }

    public function show($id) {
        echo 'Showing loan id: ' . $id . PHP_EOL;
    }

    public function edit() {}

    public function update()
    {
        echo 'post method executed' . PHP_EOL;
    }

    public function destroy() {}
}
