<?php
declare(strict_types=1);
namespace app\controllers;

class TestController extends \app\core\Controller\Controller
{
    public function test()
    {

        return  $this->request->path();

    }

}
