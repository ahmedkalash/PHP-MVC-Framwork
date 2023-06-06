<?php
declare(strict_types=1);
namespace app\controllers;

class TestController extends \app\core\Controller\Controller
{
    public function test()
    {
         //$this->sessionHandler->flush();
       //$this->sessionHandler->delete('Flash_1');
        //$this->sessionHandler->flash('Flash_1', 'Flash_2');
        $all = $this->sessionHandler->all();
        dump($all);

        dump($this->sessionHandler->newFlashDataKeys());
        dump($this->sessionHandler->oldFlashDataKeys());


        return  $this->request->path();
    }

}
