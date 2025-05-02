<?php

use App\Controllers\Articles;
use App\Controllers\AuthController;
use App\Controllers\RegisterController;
use App\Controllers\CatalogController;
use App\Core\Router\Route;

return array(
    Route::get('/', array(RegisterController::class, "index")),

    Route::get('/home', function() {
        require_once APP_PATH.'/views/pages/home.php';
    }),

    Route::get('/catalog', array(CatalogController::class, 'index')),

    Route::get('/register', array(RegisterController::class, 'index')),
    Route::post('/register', array(RegisterController::class, 'registration')),

    Route::get('/auth', array(AuthController::class, 'index')),
    Route::post('/auth', array(AuthController::class, 'login')),

    Route::get('/articles', array(Articles::class, 'index')),
    Route::post('/articles', array(Articles::class, 'getArticles')),

);