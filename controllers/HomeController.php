<?php

namespace app\controllers;

use app\core\Controller;

class HomeController extends Controller
{
    public function index(){

        return $this->viewHandler->render("home");
    }
}