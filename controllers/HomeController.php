<?php

namespace app\controllers;

use app\core\Controller;
use app\core\view\ViewPath;

class HomeController extends Controller
{
    public function index(){
        return $this->twig->render(ViewPath::HOME);
    }
}