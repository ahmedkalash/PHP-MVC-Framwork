<?php

namespace app\core;

use app\core\view\ViewPath;
use Illuminate\Container\Container;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Router
{
    protected array $routes=[];


    public function __construct(
        protected Request $request,
        protected Response $response,
        protected Container $container,
        protected Environment $twig,

    ) {}

    public function register(string $method, string $path, \Closure|string|array $action)
    {
        $this->routes[$method][$path]=$action;
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
     */
    public function resolve()
    {
        $path = $this->request->path();
        $method = $this->request->method();

        if($this->routeExists($method, $path)){
            $action = $this->routes[$method][$path];
            if(is_callable($action)){
                return call_user_func($action, $this->request);
            }
            elseif (is_string($action)){
                return $this->twig->render($action);
            }
            elseif (class_exists($action[0])){
                $className = $action[0];
                $controller = $this->container->make($className);
                $method=$action[1];

                // todo use reflection API to perform method injection
                return call_user_func([$controller,$method], $this->request);
            }
        }
        else{
           $this->response->setStatusCode(404);
           return $this->twig->render(ViewPath::ERROR_404);
        }
    }


}


