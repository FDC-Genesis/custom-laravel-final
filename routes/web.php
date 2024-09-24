<?php

use Application\Admin\Controller\AdminController;
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

Route::group(['prefix' => 'admin'], function(){

    Route::resource('/', AdminController::class)->only([
        'index', 'show', 'edit', 'update', 'destroy'
    ]);
});