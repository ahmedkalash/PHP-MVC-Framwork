<?php
declare(strict_types=1);
namespace app\controllers;

use app\core\Controller\Controller;
use app\core\Model\Model;
use app\core\Request\Request;
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
        $product = $this->container->make(Product::class);
        $product->set('name',$request->input('name'));
        $product->set('sku',$request->input('sku'));
        $product->set('price',$request->input('price'));
        $product->save();



        $product_info = $request->input('product_info');
       // dd($product_info);
        if(count($product_info) !=0){
            foreach ($product_info as $attribute=>$value){
                /** @var ProductAttributeValue $product_attribute_value*/
                $product_attribute_value = $this->container->make(ProductAttributeValue::class);
                $product_attribute_value->set('attribute', $attribute);
                $product_attribute_value->set('value', $value);
                $product_attribute_value->set('product_id', $product->get('id'));
                $product_attribute_value->save();
            }

        }

        return [
            'status'=>200,
            'location'=>'/'
        ];

    }

    public function massDelete(MassDeleteRequest $request){
       if($request->input('ids') != null ){
           Product::massDelete($request->input('ids'));
       }
       return $this->response->redirectBack();
    }

}
