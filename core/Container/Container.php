<?php

namespace App\Core\Container;

use App\Core\Config\Config;
use App\Core\DataBase\DataBase;
use App\Core\Http\Request;
use App\Core\Redirect\Redirect;
use App\Core\Router\Router;
use App\Core\Session\Session;
use App\Core\Validator\Validator;
use App\Core\View\View;
use Symfony\Contracts\Service\Attribute\Required;

class Container
{
    public Validator $validator;
    public Router $router;
    public Request $request;

    public Redirect $redirect;
    public View $view;

    public Config $config;
    public Database $db;

    public Session $session;
    public function __construct()
    {
        $this->registerContainer();
    }

    protected function registerContainer(): void
    {

        $this->request = Request::createFromGlobals();
        $this->validator=new Validator();
        $this->redirect = new Redirect();
        $this->config = new Config();
        $this->session = new Session();
        $this->request->setValidator($this->validator);
        $this->view = new View($this->session);



        $this->db = new Database($this->config);
        $this->router = new Router(
            view: $this->view,
            request:$this->request,
            redirect: $this->redirect,
            session: $this->session,
            db: $this->db,
        );

    }
}