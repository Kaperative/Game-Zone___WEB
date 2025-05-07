<?php

use App\Controllers\ArticlesController;
use App\Controllers\AuthController;
use App\Controllers\filesController;
use App\Controllers\logoutController;
use App\Controllers\RegisterController;
use App\Controllers\CatalogController;
use App\Core\Router\Route;
use App\Middleware\AuthMiddleware;

return array(
    Route::get('/', function() {
        require_once APP_PATH.'/views/pages/home.php';
    }),


    Route::get('/home', function() {
        require_once APP_PATH.'/views/pages/home.php';
    }),

    Route::get('/catalog', array(CatalogController::class, 'index')),

    Route::get('/register', array(RegisterController::class, 'index'),[AuthMiddleware::class]),
    Route::post('/register', array(RegisterController::class, 'registration'),[AuthMiddleware::class]),

    Route::get('/auth', array(AuthController::class, 'index'),[AuthMiddleware::class]),
    Route::post('/auth', array(AuthController::class, 'login'),[AuthMiddleware::class]),

    Route::get('/articles', array(ArticlesController::class, 'index')),
    Route::post('/articles', array(ArticlesController::class, 'getArticles')),

    Route::get('/logout', array(logoutController::class, 'logout'),[AuthMiddleware::class,true]),
    Route::post('/logout', array(logoutController::class, 'logout'),[AuthMiddleware::class,true]),

    Route::get('/catalog', array(CatalogController::class, 'index')),
    Route::post('/catalog', array(CatalogController::class, 'getCatalog')),

    Route::get('/files/index', array(filesController::class, 'index'),[AuthMiddleware::class,true]),
    Route::post('/files/index', array(filesController::class, 'index'),[AuthMiddleware::class,true]),
    Route::post('/catalog', array(filesController::class, 'getCatalog'),[AuthMiddleware::class,true]),

    Route::get('/files/download', [filesController::class, 'download']),






);