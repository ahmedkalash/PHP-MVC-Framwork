<?php
declare(strict_types=1);
namespace app\core;

use app\core\Request\RequestInterface;
use app\core\Response\ResponseInterface;
use app\core\Router\RouterInterface;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Application
{
    public const ROOT_DIR = __DIR__ . "/../";
    public const HELPERS_DIR = self::ROOT_DIR . "core/helpers";
    public const VIEWS_DIR = self::ROOT_DIR . "views";
    public const STORAGE_DIR = self::ROOT_DIR . "storage";

    public static Application $app;


    public function __construct(
        public RequestInterface     $request,
        public ResponseInterface    $response,
        public Container   $container,
        public Environment $twig,
        public RouterInterface      $router
    ) {
        self::$app = $this;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     * @throws BindingResolutionException
     */
    public function run()
    {
        $this->boot();
        $result = $this->router->resolve();
        $this->handelResponse($result);
        $this->shutDown();
    }


    public function handelResponse($response): void
    {
        if ($response instanceof ResponseInterface) {
            $response->send();
        } elseif (is_string($response)) {
            $this->response->setHtmlContent($response)->send();
        } elseif (is_array($response)) {
            $this->response->setJsonContent($response)->send();
        }
    }
    public function boot()
    {
        $this->twig->addGlobal('session', $_SESSION);

        if(!isset($_SESSION['previous_url'])) {
            $_SESSION['previous_url'] = $_SERVER['HTTP_HOST'] .= $_SERVER['REQUEST_URI'];
        }
        if(!isset($_SESSION['previous_path'])) {
            $_SESSION['previous_path'] = $_SERVER['REQUEST_URI'];
        }

    }

    public function shutDown()
    {
        $_SESSION['previous_url'] = $_SERVER['HTTP_HOST'] .= $_SERVER['REQUEST_URI'];
        $_SESSION['previous_path'] = $_SERVER['REQUEST_URI'];
    }


}
