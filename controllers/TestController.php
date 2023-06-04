<?php

namespace app\controllers;

class TestController extends \app\core\Controller\Controller
{
    public function test(){

        return  $this->request->path();

    }

}