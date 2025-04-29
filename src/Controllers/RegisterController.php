<?php

namespace App\Controllers;

class RegisterController
{

    public function index(): void
    {

        require_once APP_PATH.'/views/pages/register.php';

    }
}