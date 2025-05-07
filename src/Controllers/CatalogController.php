<?php

namespace App\Controllers;

use App\Core\Controller\Controller;

class CatalogController extends Controller
{
    public function index(): void
    {
        $this->view->page('/catalog');
    }

    public function getCatalog(): void
    {
        $this->request->post["num_page"];
    }

}