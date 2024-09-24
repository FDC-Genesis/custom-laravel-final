<?php

use Application\User\Controller\UserController;
use Illuminate\Support\Facades\Route as UserRoute;

$userRoute = config('route.routes')['user'];

// User Routes - Accessible at root URL '/'
UserRoute::group($userRoute, function () {
    UserRoute::resource('/', UserController::class)->only([
        'index', 'show', 'edit', 'update', 'destroy', 'create', 'store'
    ]);
});