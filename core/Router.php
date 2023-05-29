<?php

namespace app\core;



use app\core\view\ViewHandler;
use app\core\view\ViewPath;

class Router
{
    protected array $routes=[];
    private ViewHandler $viewHandler;

    public function __construct(
        protected Request $request,
        protected Response $response
    ) {
         $this->viewHandler= new ViewHandler();
    }

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
                return $this->viewHandler->render($action);
            }
            else{
                $controller = new $action[0]();
                $method=$action[1];
                return call_user_func([$controller,$method],$this->request);
            }
        }
        else{
           $this->response->setStatusCode(404);
           return $this->viewHandler->render(ViewPath::ERROR_404);
        }
    }


}


