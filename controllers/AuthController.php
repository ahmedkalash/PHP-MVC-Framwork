<?php
declare(strict_types=1);
namespace app\controllers;

use app\core\Controller\Controller;
use app\core\Request\Request;
use app\core\Request\RequestInterface;
use app\Requests\RegisterRequest;

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
        return $this->twig->render('register.twig', ['errors'=>['name'=>'an_error']]);

    }
    public function register(RegisterRequest $request)
    {

        dump($request->validate());

        dd($request);

        return "Handling submitted data in AuthController::register()";
    }
}
