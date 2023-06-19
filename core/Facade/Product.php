<?php

namespace app\core\Facade;

class Product extends Facade
{
    public static function className() : string
    {
        return \app\models\Product::class;
    }

}
