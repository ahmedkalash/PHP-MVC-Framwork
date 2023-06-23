<?php
declare(strict_types=1);
use app\controllers\AuthController;
use app\controllers\ContactController;
use app\controllers\HomeController;
use app\controllers\ProductController;

return function (\app\core\Application $app) {
    $app->router->get('/', [HomeController::class,'index']);
    $app->router->get('/add-product', [ProductController::class,'create']);

    $app->router->get('/contact', [ContactController::class,'index']);
    $app->router->post('/contact', [ContactController::class,'store']);

    $app->router->get('/login', [AuthController::class,'showLoginPage']);
    $app->router->post('/login', [AuthController::class,'login']);

    $app->router->get('/register', [AuthController::class,'showRegisterPage']);
    $app->router->post('/register', [AuthController::class,'register']);

    $app->router->get('/test', [\app\controllers\TestController::class,'test']);
};
