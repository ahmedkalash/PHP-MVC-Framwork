<?php

namespace app\controllers;

use app\core\Controller;

class AuthController extends Controller
{
    public function showLoginPage(){

    }
    public function login(){
        return "Handling submitted data in AuthController::register()";
    }
    public function showRegisterPage(){
        return $this->viewHandler->render('register');
    }
    public function register(){
        return "Handling submitted data in AuthController::register()";
    }
}