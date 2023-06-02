<?php

namespace app\core;

use app\core\Request\RequestInterface;
use Illuminate\Container\Container;
use Twig\Environment;

abstract class Controller
{
    public function __construct(
        protected RequestInterface     $request,
        protected Response    $response,
        protected Container   $container,
        protected Environment $twig,
    ) {

    }
}
