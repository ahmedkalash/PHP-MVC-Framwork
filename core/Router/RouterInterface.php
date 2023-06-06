<?php
declare(strict_types=1);
namespace app\core\Router;

use app\core\Request\RequestInterface;
use app\core\Response\ResponseInterface;
use app\core\view\ViewPath;
use Illuminate\Container\Container;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

interface RouterInterface
{

    public function get(string $path, \Closure|string|array $action);

    public function post(string $path, \Closure|string|array $action);

    public function routeExists(string $method, string $path): bool;

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError|\Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Exception
     */
    public function resolve():ResponseInterface|string|array|null;


}
