<?php

namespace LoanApi\Core\Http;

use LoanApi\Core\DependencyInjection\ContainerTrait;
use LoanApi\Core\DependencyInjection\Contracts\Locatable;

class Request implements Locatable
{
    use ContainerTrait;

    public $fullUri;
    public $uri;
    public $method;
    public $host;
    public $scheme;
    public $query;

    public function handle(array $server)
    {
        $this->fullUri = $server['REQUEST_URI'];
        $this->uri = trim(parse_url($server['REQUEST_URI'], PHP_URL_PATH), '/');
        $this->method = $server['REQUEST_METHOD'];
        $this->host = $server['HTTP_HOST'];
        $this->scheme = $server['REQUEST_SCHEME'];
        $this->query = $server['QUERY_STRING'];
        $this->args = $this->extractArgs();

        return $this;
    }

    public function getArg(string $argument)
    {
        if(array_key_exists($argument, $this->getArgs())) {
            return $this->getArgs()[$argument];
        }

        throw new InvalidArgumentException('Argument ' . $argument . ' does not exist.');
    }

    public function getArgs()
    {
        return $this->args;
    }


    public function getFullUri()
    {
        return $this->fullUri;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function isUri($uri)
    {
        return trim($this->uri, '/') === trim($uri, '/');
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function extractArgs() : array
    {
        $args = [];
        if(!empty($this->query)) {
            parse_str($this->query, $args);
        }

        return $args;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function isMethod(string $method)
    {
        return $this->method === $method;
    }

    public function url()
    {
        return $this->scheme . '/' . $this->host . '/' . $this->uri;
    }

    // with query string
    public function fullUrl()
    {
        return $this->scheme . '/' . $this->host . '/' . $this->uri . $this->query;
    }
}
