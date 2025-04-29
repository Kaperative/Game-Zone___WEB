<?php

namespace App\Core\Router;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => []
    ];

    public function __construct()
    {
        $this->initRoutes();

    }

    private function findRoute(string $uri, string $method):?Route
    {
        return $this->routes[$method][$uri] ?? null;
    }

    public function dispatch(string $uri, string $method): void
    {
        $route = $this->findRoute($uri, $method);
        if (!$route) {
            http_response_code(404);
            echo "404 Not Found";
        }

        if(is_array($route->getAction())) {
            $temp= $route->getAction();
            $controller=$temp[0];
            $action=$temp[1];

            $controller = new $controller();
            //dd($action);
            call_user_func([$controller,$action]);
        }
        else
            $route->getAction();
    }

    private function initRoutes(): void
    {
        $routes = $this->getRoutes();

        foreach ($routes as $route) {
            $this->routes[$route->getMethod()][$route->getUri()] = $route;
        }
    }

    private function getRoutes(): array
    {
        return require_once APP_PATH . '/config/routes.php';
    }
}