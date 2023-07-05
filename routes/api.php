<?php
declare(strict_types=1);

use app\controllers\ProductController;


return function (\app\core\Application $app) {
    $prefix='/api/v1';
    $app->router->post("$prefix/add-product", [ProductController::class,'store']);
    $app->router->post("$prefix/products/mass-delete", [ProductController::class,'massDelete']);
    $app->router->get("$prefix/products", [ProductController::class,'all']);

};
