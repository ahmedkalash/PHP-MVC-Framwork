<?php

namespace app\core\Facade;

use Illuminate\Container\Container;

class Facade
{
    public static function className():string
    {
        return '';
    }

    public static function __callStatic(string $name, array $arguments)
    {

        $object = Container::getInstance()->make(static::className());
        return call_user_func_array([$object, $name], $arguments);
    }


}
