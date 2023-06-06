<?php
declare(strict_types=1);

namespace app\core\Router;

use app\core\Controller\Controller;
use app\core\Exceptions\InvalidActionException;
use app\core\Exceptions\MethodNotfoundException;
use app\core\Request\RequestInterface;
use app\core\Response\ResponseInterface;
use app\core\Session\SessionHandler;
use app\core\Session\SessionHandlerInterface;
use app\core\view\ViewPath;
use Illuminate\Container\Container;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Router implements RouterInterface
{

    protected array $routes = [];


    /**
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param Container $container
     * @param Environment $twig
     */
    public function __construct(
        protected RequestInterface        $request,
        protected ResponseInterface       $response,
        protected Container               $container,
        protected Environment             $twig,
        protected SessionHandlerInterface $sessionHandler
    ) {
    }

    /**
     * @param string $method
     * @param string $path
     * @param \Closure|string|array $action
     * @return void
     */
    protected function register(string $method, string $path, \Closure|string|array $action)
    {
        $this->routes[$method][$path] = $action;
    }

    /**
     * @param string $path
     * @param \Closure|string|array $action
     * @return void
     */
    public function get(string $path, \Closure|string|array $action)
    {
        $this->register('get', $path, $action);
    }

    /**
     * @param string $path
     * @param \Closure|string|array $action
     * @return void
     */
    public function post(string $path, \Closure|string|array $action)
    {
        $this->register('post', $path, $action);
    }

    /**
     * @param string $method
     * @param string $path
     * @return bool
     */
    public function routeExists(string $method, string $path): bool
    {
        return isset($this->routes[$method][$path]);
    }


    /**
     * @return array|string|ResponseInterface|null
     * @throws InvalidActionException
     * @throws LoaderError
     * @throws MethodNotfoundException
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
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
                if (method_exists($action[0], $action[1])) {
                    return $this->callControllerMethod($action[0], $action[1]);
                }
                throw new MethodNotfoundException("Method  $action[1] not found on class $action[0]");

            } else {
                throw new InvalidActionException("Action $action is Invalid");
            }
        }
        // todo: throw new NotFoundHttpException();
        $this->response->setStatusCode(404);
        return $this->twig->render(ViewPath::ERROR_404);

    }

    /**
     * @param string $controller
     * @param string $method
     * @param array<string,mixed> $params
     * @return array|string|ResponseInterface|null
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \ReflectionException
     */

    protected function callControllerMethod(Controller|string $controller, string $method, array $params = []): array|string|ResponseInterface|null
    {
        if (is_string($controller)) {
            $controller = $this->container->make($controller);
        }

        $request = $this->getRequestObjectFormMethodParameter($controller, $method);

        if (isset($request)) {
            $validationResult = $request->validate();
            if ($validationResult === true) {

                return $this->container->call(
                    [$controller, $method],
                    array_merge($params, ['request' => $request])
                );

            } else {

                // $_SESSION['errors'] = $validationResult;
                $this->sessionHandler->flash('errors', $validationResult);

                return $this->response->redirectBack();
            }
        }

        return $this->container->call([$controller, $method], $params);
    }

    public function getRequestObjectFormMethodParameter(Controller|string $controller, string $method): ?RequestInterface
    {
        if (is_string($controller)) {
            $controller = $this->container->make($controller);
        }
        $request = null;
        $reflectionMethod = new \ReflectionMethod($controller, $method);
        $reflectionParameters = $reflectionMethod->getParameters();
        foreach ($reflectionParameters as $reflectionParameter) {
            $parameterName = $reflectionParameter->getType()->getName();
            if (is_subclass_of($parameterName, RequestInterface::class)) {
                $request = $this->container->make($parameterName);
                break;
            }
        }
        return $request;
    }


}
