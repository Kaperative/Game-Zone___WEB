<?php

namespace App\Middleware;

use App\Core\MiddleWare\AbstractMiddleWare;

class AdminMiddleware extends AbstractMiddleWare
{

        public function handle(): void
        {
            $isUserLogin = $this->auth->isAdmin();

            if (!$isUserLogin)
            {
                $this->redirect->to("/home");
            }
        }
}