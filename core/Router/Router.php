<?php

namespace App\Core\Router;

use App\Core\DataBase\DataBase;
use App\Core\Http\Request;
use App\Core\Redirect\Redirect;
use App\Core\View\View;
use App\Core\Session\Session;

class Router
{
    private array $routes = [
        'GET' => [],
        'POST' => []
    ];

    private View $view;
    private Request $request;
    private Redirect $redirect;
    private Session $session;

    private Database $dataBase;
    public function __construct(View $view, Request $request, Redirect $redirect, Session $session, Database $db )
    {
        $this->view = $view;
        $this->request = $request;
        $this->redirect = $redirect;
        $this->session = $session;
        $this->dataBase = $db;

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
            [$controller, $action] = $temp;

            $controller = new $controller();
            call_user_func_array([$controller, 'setView'], [$this->view]);
            call_user_func_array([$controller, 'setRequest'], [$this->request]);
            call_user_func_array([$controller, 'setRedirect'], [$this->redirect]);
            call_user_func_array([$controller, 'setSession'], [$this->session]);
            call_user_func_array([$controller, 'setDatabase'], [$this->dataBase]);

            call_user_func([$controller,$action]);
        }
        else
            call_user_func($route->getAction());
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