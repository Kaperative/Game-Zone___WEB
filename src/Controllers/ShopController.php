<?php

namespace App\Controllers;

use App\Core\Controller\Controller;

class ShopController extends Controller
{

    public function index(): void
    {
        $this->view->page('shop');
    }
}