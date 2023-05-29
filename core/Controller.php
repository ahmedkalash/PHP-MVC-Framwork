<?php

namespace app\core;

use app\core\view\ViewHandler;

abstract class Controller
{
    protected ViewHandler $viewHandler;
    protected Request $request;
    public function __construct()
    {
        $this->viewHandler= new ViewHandler();
        $this->request= new Request();
    }
}