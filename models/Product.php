<?php

namespace app\models;

use app\core\Model\Model;

abstract class Product extends Model
{
    protected int $id;
    protected string $name;
    protected float $price;

    protected string $table_name = "products";


    public function columns(): array
    {
        return ["id", 'name', 'price'];
    }
}
