<?php
declare(strict_types=1);

use Twig\Environment;

$container = new Illuminate\Container\Container();
$container->singleton(\Illuminate\Container\Container::class, function () use ($container) {
    return $container;
});


$container->singleton(Environment::class, function () {
    $loader = new \Twig\Loader\FilesystemLoader(\app\core\Application::VIEWS_DIR);
    return new \Twig\Environment($loader, [
        'cache' => \app\core\Application::STORAGE_DIR . '/cache',
        'auto_reload' => true
    ]);
});

$container->bind(PDO::class, function () {
    return new PDO(
        "{$_ENV['DB_CONNECTION']}:dbname={$_ENV['DB_DATABASE']};host={$_ENV['DB_HOST']}",
        $_ENV['DB_USERNAME'],
        $_ENV["DB_PASSWORD"]
    );
});

$container->bind(\app\core\InputSanitizer\InputSanitizerInterface::class, \app\core\InputSanitizer\InputSanitizer::class);

$container->bind(\app\core\Session\SessionHandlerInterface::class, app\core\Session\SessionHandler::class);

$sessionHandler = $container->make(\app\core\Session\SessionHandler::class);
$container->singleton(\app\core\Session\SessionHandler::class, function () use ($sessionHandler) {
    return $sessionHandler;
});

$request = $container->make(\app\core\Request\Request::class);
$container->singleton(\app\core\Request\Request::class, function () use ($request) {
    return $request;
});


$container->bind(\app\core\Request\RequestInterface::class, \app\core\Request\Request::class);


$response = $container->make(\app\core\Response\Response::class);
$container->singleton(\app\core\Response\Response::class, function () use ($response) {
    return $response;
});


$container->bind(\app\core\Response\ResponseInterface::class, \app\core\Response\Response::class);


$router = $container->make(\app\core\Router\Router::class);
$container->singleton(\app\core\Router\Router::class, function () use ($router) {
    return $router;
});


$container->bind(\app\core\Router\RouterInterface::class, \app\core\Router\Router::class);


$container->bind(\app\core\InputSanitizer\InputSanitizerInterface::class, \app\core\InputSanitizer\InputSanitizer::class);


$app = $container->make(\app\core\Application::class);
$container->singleton(\app\core\Application::class, function () use ($app) {
    return $app;
});
