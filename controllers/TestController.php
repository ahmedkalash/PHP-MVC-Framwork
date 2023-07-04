<?php
declare(strict_types=1);

namespace app\controllers;

use app\core\QueryBuilder\QueryBuilder;
use app\models\Product;
use app\models\ProductAttributeValue;
use app\models\User;
use Illuminate\Container\Container;
use PDO;

class TestController extends \app\core\Controller\Controller
{
    protected string $test = 'hi! i am test';

    public function test()
    {



//        dd((container()->make(PDO::class) === Container::getInstance()->make(PDO::class))  ===(Container::getInstance()->make(PDO::class) === $this->container->make(PDO::class)));
       /* if(!$this->db->beginTransaction()){
            return 'false';
        }
        try {
           $q= "INSERT INTO products VALUES(DEFAULT,'AAA','AAAAA',12)";
            $this->db->query($q);

            throw new \Exception('eeeerrrroooorrrr');


        }catch (\Throwable $throwable){
            echo $this->db->rollBack();
            // throw $throwable;
            echo '  rollBack';
            return 'false';
        }*/

/*
        $product = $this->container->make(Product::class);
        $product->set('name','ahmed')
            ->set('sku','fgf1')
            ->set('price',45);

        $status = $this->queryBuilder->transaction(function () use ($product){

           $product->save();
//            $this->queryBuilder->insert(Product::tableName(),[
//                'name'=>'ahmed',
//                'sku'=>'fgf1',
//                'price'=>'45',
//            ]);

           throw new \Exception('eeeerrrroooorrrr');
        });

        dd($status);*/






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
