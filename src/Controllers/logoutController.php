<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use JetBrains\PhpStorm\NoReturn;

class logoutController extends Controller
{
 #[NoReturn] public function logout(): void
    {

        $this->cookie->delete('ID');

        $this->redirect('/auth');
    }

}