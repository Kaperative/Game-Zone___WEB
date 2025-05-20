<?php

namespace App\Core\MiddleWare;

use App\Core\Cookies\Cookies;
use App\Core\Http\Request;
use App\Core\JsonWebToken\JsonWebToken;
use App\Core\Redirect\Redirect;
use App\Core\Session\Session;
use App\Models\User;
use App\services\AuthService;


abstract class AbstractMiddleWare
{
    protected Request $request;
    protected Redirect $redirect;
    protected Cookies $cookie;
    protected Session $session;
    protected JsonWebToken $jwt;

    protected AuthService $auth;

    protected User $user;
    public function __construct(
         Request $request,
         Redirect $redirect,
         Cookies $cookie,
         Session $session,
         JsonWebToken $jwt,
         User $user,
    )
    {
        $this->request = $request;
        $this->redirect = $redirect;
        $this->cookie = $cookie;
        $this->session = $session;
        $this->jwt = $jwt;
        $this->user = $user;
        $this->auth = new AuthService();
    }

    abstract function handle(): void;
}