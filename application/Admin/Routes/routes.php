<?php

use Application\Admin\Controller\AdminController;
use Illuminate\Support\Facades\Route as AdminRoute;

$adminRoute = config('route.routes')['admin'];

// Admin Routes - Accessible under 'admin'
AdminRoute::group($adminRoute, function () {
    AdminRoute::resource('/', AdminController::class)->only([
        'index', 'show', 'edit', 'update', 'destroy', 'create', 'store'
    ]);
});

