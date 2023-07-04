<?php
declare(strict_types=1);
namespace app\controllers;

use app\core\Controller\Controller;
use app\requests\RegisterRequest;
use app\requests\Request;

class AuthController extends Controller
{
    public function showLoginPage()
    {

    }
    public function login(): string
    {
        return "Handling submitted data in AuthController::register()";
    }
    public function showRegisterPage(Request $request): string
    {

        //dump($request);
        //unset( $_SESSION['errors']);
        return $this->twig->render('register.twig');

    }
    public function register(RegisterRequest $request)
    {

        dump($request);


        return "Handling submitted data in AuthController::register()";
    }
}
