<?php

namespace App\Controllers;

class CatalogController
{
 public function index()
 {
     require_once APP_PATH.'/views/pages/catalog.php';
 }
}