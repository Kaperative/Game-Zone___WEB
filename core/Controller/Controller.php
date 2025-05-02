<?php

namespace App\Core\Controller;
use App\Core\DataBase\DataBase;
use App\Core\Http\Request;
use App\Core\Redirect\Redirect;
use App\Core\Session\Session;
use App\Core\View\View;
use JetBrains\PhpStorm\NoReturn;


abstract  class Controller
{
    public View $view;

    public Request $request;

    public Session $session;
    public Redirect $redirect;

    public  DataBase  $database;

    public function view(string $name):void
    {
        $this->view->page($name);
    }

    #[NoReturn] public function redirect(string $path):void
    {
        $this->redirect->to($path);
    }

    public function getDatabase(): DataBase
    {
        return $this->database;
    }

    public function setDatabase(DataBase $database): void
    {
        $this->database = $database;
    }

    public function getView(): View
    {
        return $this->view;
    }

    public function setView(View $view): void
    {
        $this->view = $view;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }

    public function setRequest(Request $request): void
    {
        $this->request = $request;
    }

    public function getRedirect(): Redirect
    {
        return $this->redirect;
    }

    public function setRedirect(Redirect $redirect): void
    {
        $this->redirect = $redirect;
    }

    public function getSession(): Session
    {
        return $this->session;
    }

    public function setSession(Session $session): void
    {
        $this->session = $session;
    }

}