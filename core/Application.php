<?php

namespace app\core;

use app\core\view\ViewHandler;

class Application
{
    public Router $router;
    public Request $request;
    public Response $response;
    public ViewHandler $viewHandler;

    public const ROOT_DIR = __DIR__."/../";
    public const HELPERS_DIR = self::ROOT_DIR."/core/helpers/";
    public const VIEWS_DIR = self::ROOT_DIR."/views/";

    public static Application $app;
    public function __construct()
    {
        self::$app=$this;
        $this->request =new Request();
        $this->response =new Response();
        $this->viewHandler =new ViewHandler();
        $this->router =new Router($this->request, $this->response, $this->viewHandler);
    }

    public function run()
    {
       echo $this->router->resolve();
    }

}