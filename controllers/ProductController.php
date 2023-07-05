<?php
declare(strict_types=1);
namespace app\controllers;

use app\core\Controller\Controller;
use app\core\view\ViewPath;
use app\models\Product;
use app\models\ProductAttributeValue;
use app\requests\AddProductRequest;
use app\requests\MassDeleteRequest;

class ProductController extends Controller
{
    public function create()
    {
        return $this->twig->render(ViewPath::ADD_PRODUCT);

    }

    public function store(AddProductRequest $request){
        //dd($request);
        $units=[
            'size'=>'MB',
            'weight'=>'KG'
            ];



        $product = $this->container->make(Product::class);
        $product->set('name',$request->input('name'));
        $product->set('sku',$request->input('sku'));
        $product->set('price',$request->input('price'));
        $product->save();



        $product_info = $request->input('product_info');
        $attribute=array_keys($product_info)[0];
        $value=$product_info[$attribute];
        if(isset($product_info['height']) || isset($product_info['width']) || isset($product_info['length'])){
            $attribute="dimensions";
            $value="{$product_info['height']}x{$product_info['width']}x{$product_info['length']}";
        }


        /** @var ProductAttributeValue $product_attribute_value*/
        $product_attribute_value = $this->container->make(ProductAttributeValue::class);
        $product_attribute_value->set('attribute', $attribute);
        $product_attribute_value->set('value', $value);
        $product_attribute_value->set('product_id', $product->get('id'));
        $product_attribute_value->set('unit', $units[$attribute]??'');

        $product_attribute_value->save();


        return [
            'status'=>200,
            'location'=>'/'
        ];

    }

    public function all(){
        $products=Product::all('id',true);
        return [
            'status'=>200,
            'products'=>[
                'count'=>count($products),
                'list'=>$products
            ]
        ];
    }

    public function massDelete(MassDeleteRequest $request){
       if($request->input('ids') != null ){
           Product::massDelete($request->input('ids'));
       }

        return [
            'status'=>200,
            'location'=>'/'
        ];


    }

}
