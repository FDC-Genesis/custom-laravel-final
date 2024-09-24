<?php

namespace Application\User\Controller;

use App\Http\Controllers\Controller;

class AppController extends Controller
{
    //
    private $view;
    public function __construct(){
        $this->view = 'User';
    }
    protected function view($viewName = null, array $data = [])
    {
        // Construct the view path dynamically
        $viewPath = $viewName ? "{$this->view}::{$viewName}" : "{$this->view}::";

        // Pass data to the view
        return view($viewPath, $data);
    }
    public function handleLogin(){
        
    }
}
