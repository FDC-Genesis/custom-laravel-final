<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (!defined('ADMIN_ROUTER')) {
            define('ADMIN_ROUTER', base_path('application/Admin/Routes/routes.php'));
        }
        if (!defined('USER_ROUTER')) {
            define('USER_ROUTER', base_path('application/User/Routes/routes.php'));
        }
        
        // Add namespace for User views
        View::addNamespace('User', base_path('application/User/View'));

        // Add namespace for Admin views
        View::addNamespace('Admin', base_path('application/Admin/View'));
    }
}
