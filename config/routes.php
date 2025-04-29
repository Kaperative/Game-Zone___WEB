<?php

use App\Controllers\RegisterController;
use App\Controllers\CatalogController;
use App\Core\Router\Route;

return array(
    Route::get('/', array(RegisterController::class, "index")),

    Route::get('/home', function() {
        require_once APP_PATH.'/views/pages/home.php';
    }),

    Route::get('/catalog', array(CatalogController::class, 'index')),

    Route::get('/register', array(RegisterController::class, 'index'))
);