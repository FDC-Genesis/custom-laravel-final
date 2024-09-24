<?php

use Application\Admin\Controller\AdminController;
use Illuminate\Support\Facades\Route as AdminRoute;
use Laravel\Model\Admin;

$adminRoute = config('route.routes')['admin'];

// Admin Routes - Accessible under 'admin'
AdminRoute::group($adminRoute, function () {

    // Guests Admin
    AdminRoute::group(['middleware'=>'guestadmin'], function () {
        AdminRoute::resource('/', AdminController::class)->only([
            'create', 'store'
        ]);
    });
    
    // Authenticated Admin
    AdminRoute::group(['middleware'=>'authadmin'], function () {
        AdminRoute::resource('/', AdminController::class)->only([
            'index', 'show', 'edit', 'update', 'destroy',
        ]);
    });
});

