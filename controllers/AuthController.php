<?php
declare(strict_types=1);
namespace app\controllers;

use app\core\Controller\Controller;

class AuthController extends Controller
{
    public function showLoginPage()
    {

    }
    public function login()
    {
        return "Handling submitted data in AuthController::register()";
    }
    public function showRegisterPage()
    {
        return $this->twig->render('register.twig');
    }
    public function register()
    {
        return "Handling submitted data in AuthController::register()";
    }
}
