<?php

namespace LoanApi\Controllers;

use LoanApi\Core\Http\Response;
use LoanApi\Core\Router\Controller as BaseController;
use LoanApi\Repositories\LoanRepository;

class LoanController extends BaseController
{
    private $loanRepository;

    public function __construct(LoanRepository $loanRepository)
    {
        $this->loanRepository = $loanRepository;
    }

    public function index()
    {
        $data = $this->loanRepository->all();

        return (new Response($data, 200))->toJson();
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
        $loan = $this->loanRepository->getLoan(1);
        $amortization = $this->container->get('amortization', true);
        $amortization->handle($loan['amount'], $loan['interest_rate'], $loan['months']);

        die(var_dump($amortization));

        return (new Response($amortizationData, 200))->jsonResponse();
    }

    public function destroy() {}

    public function migrate()
    {
        $queryString = 'create table loans(id int not null auto_increment, amount float, interest_rate float, months smallint, date date, primary key(id));';
    }
}
