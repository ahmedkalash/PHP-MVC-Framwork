<?php
declare(strict_types=1);

namespace app\controllers;

use app\models\User;

class TestController extends \app\core\Controller\Controller
{
    protected string $test = 'hi i am test';

    public function test()
    {

        $user = $this->container->make(User::class);

        dd($user);

        dump($this->sessionHandler->newFlashDataKeys());
        dump($this->sessionHandler->oldFlashDataKeys());


        return $this->request->path();
    }

}
