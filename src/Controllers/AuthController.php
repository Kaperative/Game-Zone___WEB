<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Core\DataBase\Model\User;
use JetBrains\PhpStorm\NoReturn;

class AuthController extends Controller
{
    public function index(): void
    {
        $this->view->page('/auth');
    }
    #[NoReturn] public function login(): void
    {
        $data=$this->request->post;
        $user=new User();
        if(!$user->findByLogin($data['login'])||! $user->verifyPassword($data['login'],$data['password']))
        {
            $this->session->set('login_error',"User isn't created or password isn't correct");
            $this->redirect($this->request->getUri());
        }


        $this->redirect('/home');
    }
}