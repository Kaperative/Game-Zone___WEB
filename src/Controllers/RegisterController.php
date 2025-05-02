<?php

namespace App\Controllers;

use App\Core\Controller\Controller;
use App\Core\DataBase\Model\User;
use JetBrains\PhpStorm\NoReturn;


class RegisterController extends Controller
{

    #[NoReturn] public function index(): void
    {
        $this->view('register');
    }

    #[NoReturn] public function registration(): void
    {
        $data = $this->request->post;

        $rules = [
            'username'=> "required|min:4|max:80",
            'password'=> "required|min:8",
            'email'=> "required|email",
        ];
        // dd($this->database);
        $isValidate= $this->request->validator->validate($data,$rules);
        if(!$isValidate)
        {
            $errors = $this->request->validator->getErrors();
            foreach ($errors as $key => $error) {
                $this->session->set($key, $error);
            }
            $this->redirect($this->request->getUri()); // redirect in this page
        }

        $data = [
            'login' => $data['username'],
            'email' => $data['email'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        ];

        $user = new User();
        if ($user->findByLogin($data['login']))
        {
            $this->session->set('username','this login is busy');
            $this->redirect($this->request->getUri()); // redirect in this page
        }
        if($user->findByEmail($data['email']))
        {
            $this->session->set('email','this  email is busy');
            $this->redirect($this->request->getUri()); // redirect in this page
        }
        if(!$user->create($data))
            exit("FALSE PDO");
        $this->redirect('/auth');
    }
}