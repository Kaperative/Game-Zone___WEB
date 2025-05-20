<?php

namespace App\Core\Router;

use App\Core\Cookies\Cookies;
use App\Core\DataBase\DataBase;
use App\Core\Http\Request;
use App\Core\JsonWebToken\JsonWebToken;
use App\Core\MiddleWare\AbstractMiddleWare;
use App\Core\Redirect\Redirect;
use App\Core\Session\Session;
use App\Core\View\View;
use App\Models\User;

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
    private Cookies $cookies;

    private JsonWebToken $jwt;

    private User $user;

    public function __construct(View $view, Request $request, Redirect $redirect, Session $session, Cookies $cookies, Database $db )
    {
        $this->view = $view;
        $this->request = $request;
        $this->redirect = $redirect;
        $this->session = $session;
        $this->cookies = $cookies;
        $this->dataBase = $db;
        $this->jwt = new JsonWebToken();
        $this->initRoutes();
        $this->user = new User();
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
            return;
        }

        $middlewares = $route->getMiddleware();
        if(!empty($middlewares))
        {
           $middleware = $middlewares[0];
                /**
                 * @var AbstractMiddleWare $middleware
                 */
                $middleware = new $middleware($this->request, $this->redirect, $this->cookies, $this->session, $this->jwt,$this->user);

                if (empty($middlewares[1]))
                {
                    $middleware->handle();
                }
                else{
                    $middleware -> handle($middlewares[1]);
                }
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
            call_user_func_array([$controller, 'setCookie'], [$this->cookies]);
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

    public function getCookies(): Cookies
    {
        return $this->cookies;
    }

    public function setCookies(Cookies $cookies): void
    {
        $this->cookies = $cookies;
    }
}