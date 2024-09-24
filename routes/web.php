<?php

use Application\Admin\Controller\AdminController;
use Application\User\Controller\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
[$adminRoute, $userRoute] = config('route.routes');

// Admin Routes - Accessible under 'admin'
Route::group($adminRoute, function () {
    Route::resource('/', AdminController::class)->only([
        'index', 'show', 'edit', 'update', 'destroy', 'create', 'store'
    ]);
});

// User Routes - Accessible at root URL '/'
Route::group($userRoute, function () {
    Route::resource('/', UserController::class)->only([
        'index', 'show', 'edit', 'update', 'destroy', 'create', 'store'
    ]);
});
