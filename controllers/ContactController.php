<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request\Request;
use app\core\view\ViewPath;

class ContactController extends Controller
{
    public function index(): string
    {
        $data = [
            'lastName'=>'kalash',
            'firstName'=>'ahmed',
            'age'=>123
        ];
        return $this->twig->render(ViewPath::CONTACT, $data);
    }
    public function store(Request $request)
    {
        //var_dump($request);
        return "Handling submitted data in ContactController::store() ";
    }
}
