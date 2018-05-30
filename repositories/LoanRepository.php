<?php

namespace LoanApi\Repositories;

use LoanApi\Core\DependencyInjection\ContainerTrait;
use LoanApi\Core\DependencyInjection\Contracts\Locatable;

// query stuff for the controllers
class LoanRepository implements Locatable
{
    use ContainerTrait;

    public function all()
    {
        return [
            'loan1' => 'a',
            'loan2' => 'b'
        ];
    }
}
