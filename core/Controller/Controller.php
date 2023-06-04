<?php

namespace app\core\Controller;

use app\core\Request\RequestInterface;
use app\core\Response\ResponseInterface;
use Illuminate\Container\Container;
use Twig\Environment;

abstract class Controller implements ControllerInterface
{
    public function __construct(
        protected RequestInterface     $request,
        protected ResponseInterface    $response,
        protected Container   $container,
        protected Environment $twig,
    ) {

    }
}
