<?php

namespace App\Core\View;

use App\Core\Cookies\Cookies;
use App\Core\Session\Session;
use App\Core\Services\AuthService;
class View
{
    private Session $session;
    private  Cookies $cookies;
    private AuthService $auth;
    public function __construct(Session $session, Cookies $cookies)
    {
        $this->session = $session;
        $this -> cookies = $cookies;
        $this->auth = new AuthService();
    }
    public function page(string $page):void
    {
        extract($this->getDefaultVariables()); // all variables in method of class (clear this methode)
        require_once APP_PATH."/views/pages/$page.php";
    }

    public function includeComponent(string $component):void
    {
        extract($this->getDefaultVariables()); // all variables in method of class (clear this methode)
        require_once APP_PATH."/views/components/$component.php";
    }

    public function render(string $view, $variables):void
    {
        extract($variables);
        require_once APP_PATH."/views/pages/files/index.php";
    }
    private function getDefaultVariables():array
    {
        return [
            'view' => $this,
            'session'=>$this->session,
            'cookies'=>$this->cookies,
            'auth'=>$this->auth,
        ];
    }
}