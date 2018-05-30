<?php

namespace LoanApi\Repositories;

// query stuff for the controllers
class LoanRepository
{
    public function __construct()
    {
        // echo get_class($this) . ' Loaded';
    }

    public function all()
    {
        return [
            'data' => [
                'loan1' => 'a',
                'loan2' => 'b',
            ]
        ];
    }
}
