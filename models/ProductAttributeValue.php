<?php

namespace app\models;

class ProductAttributeValue extends \app\core\Model\Model
{

    protected static string $table_name = 'product_attributes_values';
    /**
     * @inheritDoc
     */
    public static function columns(): array
    {
        return ['id','attribute','product_id','value','unit'];
    }
}
