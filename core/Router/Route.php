<?php

namespace App\Core\Router;

class Route
{
    private string $method;
    private string $uri;
    private $action;

    private array $middleware;
    private function __construct(string $method, string $uri, $action, array $middleware=null)

    {

        $this->method = $method;
        $this->uri = $uri;
        $this->action = $action;
        $this->middleware = $middleware ?? null;
    }

    public  static function get(string $uri, $action,array $middleware=[]): static
    {
        return new static('GET', $uri, $action,$middleware);
    }

    public static function post(string $uri,  $action,array $middleware=[]): static
    {
        return new static('POST', $uri, $action, $middleware);
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

    public function hasMiddleware(): bool
    {
        return !empty($this->middleware);
    }

    public function getMiddleware(): ?array
    {
        return $this->middleware;
    }
}