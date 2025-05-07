<?php

namespace App\Core\MiddleWare;

use App\Core\Cookies\Cookies;
use App\Core\DataBase\Model\User;
use App\Core\Http\Request;
use App\Core\JsonWebToken\JsonWebToken;
use App\Core\Redirect\Redirect;
use App\Core\Session\Session;


abstract class AbstractMiddleWare
{
    protected Request $request;
    protected Redirect $redirect;
    protected Cookies $cookie;
    protected Session $session;
    protected JsonWebToken $jwt;

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
    }

    abstract function handle(): void;
}