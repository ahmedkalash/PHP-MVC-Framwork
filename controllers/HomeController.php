<?php

namespace app\controllers;

use app\core\Controller;

class HomeController extends Controller
{
    public function index(){
        var_dump(urldecode($_SERVER['REQUEST_URI']));
        return $this->viewHandler->render("home");
    }
}