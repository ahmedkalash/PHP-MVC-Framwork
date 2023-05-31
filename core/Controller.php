<?php

namespace app\core;


use Illuminate\Container\Container;
use Twig\Environment;

abstract class Controller
{

    public function __construct(
        public Request     $request,
        public Response    $response,
        public Container   $container,
        public Environment $twig,
    ){


    }
}