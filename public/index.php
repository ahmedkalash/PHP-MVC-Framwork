<?php
declare(strict_types=1);
/*** @var $container Illuminate\Container\Container*/
/*** @var $app \app\core\Application*/
//phpinfo();

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->safeLoad();

require_once __DIR__ . "/../core/bingings.php";



$container->make(\app\core\Application::class);
$routesClosure = include_once \app\core\Application::ROOT_DIR . '/routes/web.php';
$container->call($routesClosure, ['app'=>$app]);

$app->run();

exit();
