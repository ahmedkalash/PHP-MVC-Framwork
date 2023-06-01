<?php

use Twig\Environment;

$container = new Illuminate\Container\Container();
$container->singleton(\Illuminate\Container\Container::class, function () use ($container) {
    return $container;
});


$container->singleton(Environment::class, function () {
    $loader = new \Twig\Loader\FilesystemLoader(\app\core\Application::VIEWS_DIR);
    return new \Twig\Environment($loader, [
        'cache' => \app\core\Application::STORAGE_DIR . '/cache',
    ]);
});


$request = $container->make(\app\core\Request::class);
$container->singleton(\app\core\Request::class, function () use ($request) {
    return $request;
});


$response = $container->make(\app\core\Response::class);
$container->singleton(\app\core\Response::class, function () use ($response) {
    return $response;
});


$router = $container->make(\app\core\Router::class);
$container->singleton(\app\core\Router::class, function () use ($router) {
    return $router;
});


$app = $container->make(\app\core\Application::class);
$container->singleton(\app\core\Application::class, function () use ($app) {
    return $app;
});
