<?php

use App\Controllers\AdminController;
use App\Controllers\AuthController;

use App\Controllers\HelpController;
use App\Controllers\HomeController;
use App\Controllers\logoutController;
use App\Controllers\RegisterController;
use App\Controllers\ShopController;
use App\Core\Router\Route;
use App\Middleware\AdminMiddleware;
use App\Middleware\AuthMiddleware;

return array(
    Route::get('/',array(HomeController::class, 'index') ),

    Route::get('/home',array(HomeController::class, 'index')),
    Route::post('/home',array(HomeController::class, 'submit')),
    Route::post('/',array(HomeController::class, 'submit')),

    Route::get('/register', array(RegisterController::class, 'index'),[AuthMiddleware::class]),
    Route::post('/register', array(RegisterController::class, 'registration'),[AuthMiddleware::class]),

    Route::get('/auth', array(AuthController::class, 'index'),[AuthMiddleware::class]),
    Route::post('/auth', array(AuthController::class, 'login'),[AuthMiddleware::class]),




    Route::get('/logout', array(logoutController::class, 'logout'),[AuthMiddleware::class,true]),
    Route::post('/logout', array(logoutController::class, 'logout'),[AuthMiddleware::class,true]),


    Route::get('/shop', [ShopController::class, 'index']),
    Route::post('/shop', [ShopController::class, 'requestMethodPOST']),

////////////// help ///////////////////////

    Route::get('/help/help', array(HelpController::class, 'index'),[AuthMiddleware::class,true]),
    Route::get('/help/main', array(HelpController::class, 'indexMain'),[AuthMiddleware::class,true]),


    Route::post('/help/delete', [AdminController::class, 'deleteArticle'],[AuthMiddleware::class]),
    Route::post('/help/mail', [HelpController::class, 'saveSupportRequest'],[AuthMiddleware::class,true]),



//////////////// ADMIN PANEL /////////////////

    /// main
    Route::get('/admin/main', [AdminController::class, 'index'],[AdminMiddleware::class]),

    //users
    Route::get('/admin/users', [AdminController::class, 'indexAdmins'],[AdminMiddleware::class]),


    Route::post('/admin/delete-user', [AdminController::class, 'deleteUser'],[AdminMiddleware::class]),
    Route::post('/admin/setAdmin', [AdminController::class, 'setAdmin'],[AdminMiddleware::class]),
    Route::post('/admin/unsetAdmin', [AdminController::class, 'unsetAdmin'],[AdminMiddleware::class]),

    // Articles
    Route::get('/admin/articles', array(AdminController::class, 'indexArticles'),[AdminMiddleware::class]),
    Route::post('/admin/save-article', array(AdminController::class, 'addArticle'),[AdminMiddleware::class]),
    Route::post('/admin/send-answer', array(AdminController::class, 'sendAnswer'),[AdminMiddleware::class]),

    Route::post('/admin/delete-article', [AdminController::class, 'deleteArticle'],[AdminMiddleware::class]),
    Route::post('/admin/add-article', [AdminController::class, 'addArticle'],[AdminMiddleware::class]),

    // Comments
    Route::get('/admin/articles', array(AdminController::class, 'indexArticles'),[AdminMiddleware::class]),

    Route::post('/admin/delete-article', [AdminController::class, 'deleteArticle'],[AdminMiddleware::class]),
    Route::post('/admin/add-article', [AdminController::class, 'addArticle'],[AdminMiddleware::class]),

    // Support
    Route::get('/admin/support', array(AdminController::class, 'indexSupport'),[AdminMiddleware::class]),

    Route::post('/admin/delete-support', [AdminController::class, 'deleteSupport'],[AdminMiddleware::class]),

    // Brands
    Route::get('/admin/brands', array(AdminController::class, 'indexBrands'),[AdminMiddleware::class]),

    Route::post('/admin/delete-brand', [AdminController::class, 'deleteBrand'],[AdminMiddleware::class]),
    Route::post('/admin/add-brand', [AdminController::class, 'createBrand'],[AdminMiddleware::class]),

    // Sizes
    Route::get('/admin/sizes', array(AdminController::class, 'indexSizes'),[AdminMiddleware::class]),

    Route::post('/admin/delete-size', [AdminController::class, 'deleteSize'],[AdminMiddleware::class]),
    Route::post('/admin/add-brand', [AdminController::class, 'addSize'],[AdminMiddleware::class]),

    // Colors
    Route::get('/admin/colors', array(AdminController::class, 'indexColor'),[AdminMiddleware::class]),

    Route::post('/admin/delete-color', [AdminController::class, 'deleteColor'],[AdminMiddleware::class]),
    Route::post('/admin/add-color', [AdminController::class, 'addColor'],[AdminMiddleware::class]),

    // Categories
    Route::get('/admin/categories', array(AdminController::class, 'indexCategories'),[AdminMiddleware::class]),

    // LOGS
    Route::get('/admin/logs', array(AdminController::class, 'indexLogs'),[AdminMiddleware::class]),

    // Universal methods
    Route::post('/admin/delete', [AdminController::class, 'delete'],[AdminMiddleware::class]),
    Route::post('/admin/add', [AdminController::class, 'add'],[AdminMiddleware::class]),
















);