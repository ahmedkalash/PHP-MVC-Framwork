<?php

use app\core\Router;
use Twig\Environment;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . "/../core/bingings.php";

//phpinfo();

$container->make(\app\core\Application::class);
$routesClosure = include_once \app\core\Application::ROOT_DIR . '/routes/web.php';



call_user_func($routesClosure, $app);

$app->run();
exit();
