<?php

namespace App\Core\Router;

class Route
{
    private string $method;
    private string $uri;
    private $action;

    public  static function get(string $uri, $action): self
    {
        return new self('GET', $uri, $action);
    }

    public static function post(string $uri,  $action): self
    {
        return new self('POST', $uri, $action);
    }

    private function __construct(string $method, string $uri, $action)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getAction()
    {
        return $this->action;
    }
}