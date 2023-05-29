<?php

namespace app\controllers;

use app\core\Controller;
use app\core\Request;
use app\core\view\ViewPath;

class ContactController extends Controller
{
    public function index(){
        $data = [
            'lastName'=>'kalash',
            'firstName'=>'ahmed',
            'age'=>123
        ];
        return $this->viewHandler->render(ViewPath::CONTACT, $data);
    }
    public function store(Request $request){
         return "Handling submitted data in ContactController::store() ";
    }
}