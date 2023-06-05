<?php
declare(strict_types=1);
namespace app\controllers;

class TestController extends \app\core\Controller\Controller
{
    public function test()
    {
       dd( $_SESSION['previous_url'] = $_SERVER['HTTP_HOST'].= $_SERVER['REQUEST_URI']);
        return  $this->request->path();

    }

}
