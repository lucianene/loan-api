<?php

namespace LoanApi\Core\Http;

use LoanApi\Core\DependencyInjection\LocatableService;

class Response extends LocatableService
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function toJson()
    {
        return json_encode($this->data);
    }
}
