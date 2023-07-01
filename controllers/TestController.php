<?php
declare(strict_types=1);

namespace app\controllers;

use app\models\Product;
use app\models\ProductAttributeValue;
use app\models\User;
use PDO;

class TestController extends \app\core\Controller\Controller
{
    protected string $test = 'hi! i am test';

    public function test()
    {
        $selectQuery =  $this->container->make(\PDO::class)
            ->prepare("SELECT COUNT(*) as count FROM products WHERE sku = 'ADF12254he77'");

        $selectQuery->execute();
         dd($selectQuery->fetch(PDO::FETCH_ASSOC)['count']);
      //dd((string) true);


        return[
          'status'=>123,
          'errors'=>[
              'name'=>'this field is required'
          ]
        ];




        //        $product = $this->container->make(Product::class);
        //        $product->set('name', 'test2')
        //            ->set('sku',2222)
        //            ->set('price', 2222);
        //        $product->save();

        //        $productAttributeValue = $this->container->make(ProductAttributeValue::class);
        //        $productAttributeValue
        //            ->set('attribute','height')
        //            ->set('product_id',1012)
        //            ->set('value',26);
        //        $productAttributeValue->save();

        //        $this->queryBuilder->insert(ProductAttributeValue::tableName(),[
        //            'attribute'=>'mark',
        //            'product_id'=>1003,
        //            'value'=>'Asus',
        //
        //
        //        ]);

        $products = Product::all();
        dump($products);

        dd(ProductAttributeValue::all());

        //        $products = Product::selectWhere('products','id','>',0);
        dd($products);


        return $this->request->path();
    }

}
