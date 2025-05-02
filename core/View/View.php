<?php

namespace App\Core\View;

use App\Core\Session\Session;

class View
{
    private Session $session;
    public function __construct(Session $session)
    {
        $this->session = $session;
    }
    public function page(string $page):void
    {
        extract($this->getDefaultVariables()); // all variables in method of class (clear this methode)
        require_once APP_PATH."/views/pages/$page.php";
    }

    public function includeComponent(string $component):void
    {

        require_once APP_PATH."/views/components/$component.php";
    }

    private function getDefaultVariables():array
    {
        return [
            'view' => $this,
            'session'=>$this->session,
        ];
    }
}