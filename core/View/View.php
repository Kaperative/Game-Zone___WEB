<?php

namespace App\Core\View;

use App\Core\Cookies\Cookies;
use App\Core\Session\Session;
use App\Models\User;
use App\services\AuthService;
use App\Core\Config\Config;
class View
{
    private Session $session;
    private  Cookies $cookies;
    private AuthService $auth;
    private User $user;

    private Config $config;

    private array $defaultVariables ;
    public function __construct(Session $session, Cookies $cookies)
    {
        $this->config= new Config();
        $this->session = $session;
        $this->user = new User();
        $this -> cookies = $cookies;
        $this->auth = new AuthService();

        $this->defaultVariables=$this->getDefaultVariables();
    }
    public function page(string $page):void
    {
        extract($this->defaultVariables);
        require_once APP_PATH."/views/pages/$page.php";
    }

    public function includeComponent(string $component):void
    {

        extract($this->defaultVariables);
        require_once APP_PATH."/views/components/$component.php";
    }

    public function includeScripts(string $script): void
    {
        require_once APP_PATH."/views/scripts/$script.php";
    }

    public function render(string $page, array $variables=[]):void
    {

       $this->defaultVariables=array_merge($this->defaultVariables,$variables);
        extract($this->defaultVariables);
        require APP_PATH."/views/pages/{$page}.php";
    }
    private function getDefaultVariables():array
    {
        return [
            'view' => $this,
            'session'=>$this->session,
            'cookies'=>$this->cookies,
            'auth'=>$this->auth,
            'user'=>$this->user,
            'configUI'=>$this->config->getAll('configUI'),
            'isAdmin'=>$this->auth->isAdmin(),
            'isAuthorize'=> $this->auth->isLogin()
        ];
    }
}