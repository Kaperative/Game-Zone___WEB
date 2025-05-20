<?php

namespace App\Middleware;

use App\Core\MiddleWare\AbstractMiddleWare;
use App\Core\MiddleWare\Middleware;

class AuthMiddleware extends AbstractMiddleWare
{

    // REVERSE is param for pages for user that is login
        public function handle(bool $reverse=false): void
        {
            $isUserLogin = $this->auth->isLogin();

            if ( $isUserLogin ^ $reverse)
            {
                $this->redirect->to("/home");
            }


        }

}