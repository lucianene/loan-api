<?php

namespace LoanApi\Repositories;

use LoanApi\Amortization;
use LoanApi\Core\Database\Database;
use LoanApi\Core\DependencyInjection\ContainerTrait;
use LoanApi\Core\DependencyInjection\Contracts\Locatable;

// query stuff for the controllers
class LoanRepository implements Locatable
{
    use ContainerTrait;

    private $amortization;
    private $database;

    public function __construct(Amortization $amortization, Database $database)
    {
        $this->amortization = $amortization;
        $this->database = $database;
    }

    public function all()
    {
        return $this->database->query('SELECT * FROM loans')->get();
    }

    public function getLoan($id)
    {
        $loans = $this->database->query('SELECT * FROM loans WHERE id=' . $id)->get();
        return array_pop($loans);
    }

}
