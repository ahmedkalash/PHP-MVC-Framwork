<?php
declare(strict_types=1);

namespace app\requests;

use app\core\Request\Request;
use app\core\Validator\Validator;
use app\models\Product;

class AddProductRequest extends Request
{

    public function validate(): bool|array
    {
        $errors = [];
        if ($this->validateName() !== true) {
            $errors = array_merge($errors, $this->validateName());
        }
        if ($this->validateSku() !== true) {
            $errors = array_merge($errors, $this->validateSku());
        }
        if ($this->validatePrice() !== true) {
            $errors = array_merge($errors, $this->validatePrice());
        }
        if ($this->validateProductType() !== true) {
            $errors = array_merge($errors, $this->validateProductType());
        }

        return count($errors) ? $errors : true;
    }

    private function validateName()
    {
        $field_name = 'name';
        $name = $this->input($field_name);
        //$errorMessage = null;

        if(($res = Validator::notNull($name,$field_name)) !== true){
            return $res;
        }
        if(($res = Validator::notEmpty($name,$field_name)) !== true){
            return $res;
        }
        if(($res = Validator::maxLength($name,255,$field_name)) !== true){
            return $res;
        }

        return true;
       /*
       if(is_null($name) || $name==''){
            $errorMessage = "Name is required";
        }
        return $errorMessage ? [$field_name => $errorMessage] : true;
       */



    }

    private function validateSku()
    {
        $field_name = 'sku';
        $sku = $this->input($field_name);
        //$errorMessage = null;

        if(($res = Validator::notNull($sku,$field_name)) !== true){
            return $res;
        }
        if(($res = Validator::notEmpty($sku,$field_name)) !== true){
            return $res;
        }
        if(($res = Validator::unique($sku, Product::tableName(),'sku',$field_name)) !== true){
            return $res;
        }

        return true;

        /*if(is_null($sku) || $sku==''){
            $errorMessage = "SKU is required";
        }
        return $errorMessage ? [$field_name => $errorMessage] : true;*/

    }

    private function validatePrice()
    {
        $field_name = 'price';
        $price = $this->input($field_name);
       // $errorMessage = null;

        if(($res = Validator::notNull($price,$field_name)) !== true){
            return $res;
        }
        if(($res = Validator::number($price,$field_name)) !== true){
            return $res;
        }
        if(($res = Validator::float($price,8,2,$field_name)) !== true){
            return $res;
        }


        return true;
      /*  if(is_null($price) || $price=='' || $price==0){
            $errorMessage = "Price is required";
        }elseif(!is_numeric($price)){
            $errorMessage = "Price must be a number";
        }
      return $errorMessage ? [$field_name => $errorMessage] : true;
      */



    }
    private function validateProductType()
    {
        $field_name = 'product_type';
        $productType = $this->input($field_name);
        //$errorMessage = null;


        if(($res = Validator::notNull($productType,$field_name)) !== true){
            return $res;
        }
        if(($res = Validator::notEmpty($productType,$field_name)) !== true){
            return $res;
        }
        if(($res = Validator::oneOf($productType,['dvd','book','furniture'],$field_name)) !== true){
            return $res;
        }

        return true;

/*
        if(is_null($productType) || $productType==''){
            $errorMessage = "Product type is required";
        }elseif(!in_array($productType,['dvd','book','furniture'])){
             $errorMessage = "Invalid product type";
        }

        return $errorMessage ? [$field_name => $errorMessage] : true;*/
    }


}