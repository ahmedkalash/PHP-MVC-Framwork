<?php
declare(strict_types=1);

use app\controllers\HomeController;
use app\controllers\ProductController;

return function (\app\core\Application $app) {
    $app->router->get('/', [HomeController::class,'index']);
    $app->router->get('/add-product', [ProductController::class,'create']);


};
