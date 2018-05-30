<?php

namespace LoanApi\Controllers;

use LoanApi\Core\Http\Request;
use LoanApi\Repositories\LoanRepository;

class LoanController extends ApiController
{
    public function index()
    {
        // $loanRepository = $this->container->get('repositories.loan');
        // die(var_dump($this->request));
        // die(var_dump($this->request->getArgs()));
        // die(var_dump($this->request->getArg('limit')));

        // $data = $this->loanRepository->limit($request->getArg('limit'))->get();

        return $this->jsonResponse([
            'data' => ['test']
            // 'data' => $loanRepository->all()
        ]);
    }

    public function create() {}

    public function store() {
        echo 'put method executed' . PHP_EOL;
    }

    public function show($id) {
        echo 'Showing loan id: ' . $id . PHP_EOL;
    }

    public function edit() {}

    public function update(Request $request)
    {
        die(var_dump($request));
        echo 'post method executed' . PHP_EOL;
    }

    public function destroy() {}
}
