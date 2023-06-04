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

class Router implements RouterInterface
{
    protected array $routes = [];


    public function __construct(
        protected RequestInterface  $request,
        protected ResponseInterface $response,
        protected Container         $container,
        protected Environment       $twig,
    ) {
    }

    protected function register(string $method, string $path, \Closure|string|array $action)
    {
        $this->routes[$method][$path] = $action;
    }

    public function get(string $path, \Closure|string|array $action)
    {
        $this->register('get', $path, $action);
    }

    public function post(string $path, \Closure|string|array $action)
    {
        $this->register('post', $path, $action);
    }

    public function routeExists(string $method, string $path): bool
    {
        return isset($this->routes[$method][$path]);
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError|\Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Exception
     */
    public function resolve(): array|string|ResponseInterface|null
    {
        $path = $this->request->path();
        $method = $this->request->method();

        if ($this->routeExists($method, $path)) {
            $action = $this->routes[$method][$path];

            if (is_callable($action)) {
                return $this->container->call($action);
            } elseif (is_string($action)) {
                return $this->twig->render($action);
            } elseif (class_exists($action[0])) {
                $className = $action[0];
                $controller = $this->container->make($className);
                $method = $action[1];
                return $this->container->call([$controller, $method]);
            } else {
                throw new \Exception('Un known action '.$action);
            }
        }
        $this->response->setStatusCode(404);
        return $this->twig->render(ViewPath::ERROR_404);

    }


}
