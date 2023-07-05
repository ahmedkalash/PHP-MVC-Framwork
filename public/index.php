<?php
declare(strict_types=1);
/*** @var $container Illuminate\Container\Container*/
/*** @var $app \app\core\Application*/
//phpinfo();

set_exception_handler(function ($exception){
    return null;
});

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

require_once __DIR__ . "/../core/bingings.php";


$routesFiles=[
    'web',
    'api'
];
foreach ($routesFiles as $routesFile){
    $routesClosure = include_once \app\core\Application::ROOT_DIR . "/routes/$routesFile.php";
    $container->call($routesClosure, ['app'=>$app]);
}

//$container->make(\app\core\Application::class);


$app->run();

exit();
