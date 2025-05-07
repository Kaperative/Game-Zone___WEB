<?php

namespace App\Middleware;

use App\Core\MiddleWare\AbstractMiddleWare;
use App\Core\MiddleWare\Middleware;

class AuthMiddleware extends AbstractMiddleWare
{

    // REVERSE is param for pages for user that is login
    public function handle(bool $reverse=false): void
    {
        $isUserLogin = false;

        if (!empty($this->cookie->get('ID'))) {
            $isUserLogin = true;
        }

        // $isUserLogin 1 1 0 0
        // reverse      1 0 1 0
        // result       0 1 1 0



        if ( $isUserLogin ^ $reverse)
        {
            $this->redirect->to("/home");
        }


    }

}