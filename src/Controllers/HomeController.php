<?php

namespace App\Controllers;

use App\Core\Controller\Controller;

class HomeController extends Controller
{

    public function index(): void
    {
        $this->view->page("/home");
    }

    public function submit(): void
    {
        if(isset($_POST['btnReg'])) {
            $this->redirect("/register");
        }
        if(isset($_POST["btnAuth"]))
        {
            $this->redirect("/auth");
        }
    }
}