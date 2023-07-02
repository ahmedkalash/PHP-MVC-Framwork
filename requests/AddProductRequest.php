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
        if ($this->validateProductInfo() !== true) {
            $errors = array_merge($errors, $this->validateProductInfo());
        }
        if ($this->validateProductInfoFloat('size') !== true) {
            $errors = array_merge($errors, $this->validateProductInfoFloat('size'));
        }
        if ($this->validateProductInfoFloat('weight') !== true) {
            $errors = array_merge($errors, $this->validateProductInfoFloat('weight'));
        }
        if ($this->validateProductInfoFloat('height') !== true) {
            $errors = array_merge($errors, $this->validateProductInfoFloat('height'));
        }
        if ($this->validateProductInfoFloat('width') !== true) {
            $errors = array_merge($errors, $this->validateProductInfoFloat('width'));
        }

        if ($this->validateProductInfoFloat('length') !== true) {
            $errors = array_merge($errors, $this->validateProductInfoFloat('length'));
        }


        return count($errors) ? $errors : true;
    }

    private function validateName()
    {
        $field_name = 'name';
        $name = $this->input($field_name);

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


    }

    private function validateSku()
    {
        $field_name = 'sku';
        $sku = $this->input($field_name);

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

    }

    private function validatePrice()
    {
        $field_name = 'price';
        $price = $this->input($field_name);

        if(($res = Validator::required($price,$field_name)) !== true){
            return $res;
        }
        if(($res = Validator::number($price,$field_name)) !== true){
            return $res;
        }
        if(($res = Validator::float($price,8,2,$field_name)) !== true){
            return $res;
        }
        return true;
    }
    private function validateProductType()
    {
        $field_name = 'product_type';
        $productType = $this->input($field_name);

        if(($res = Validator::required($productType,$field_name)) !== true){
            return $res;
        }

        if(($res = Validator::oneOf($productType,['dvd','book','furniture'],$field_name)) !== true){
            return $res;
        }

        return true;

    }
    private function validateProductInfo()
    {
        $field_name = 'product_info';
        $productInfo = $this->input($field_name);

        if(($res = Validator::notNull($productInfo,'product_type')) !== true){
            return $res;
        }

        if(count($productInfo) ==0){
            return[
                'product_type'=> "This field is required"
             ];
        }
        return true;

    }
    private function validateProductInfoFloat(string $field_name){
        $product_info=$this->input("product_info");
        if(isset($product_info[$field_name])){
            $value = $product_info[$field_name];

            if(($res = Validator::notEmpty($value,$field_name)) !== true){
                return $res;
            }
            if(($res = Validator::number($value,$field_name)) !== true){
                return $res;
            }
            if(($res = Validator::float($value,8,2,$field_name)) !== true){
                return $res;
            }
        }
        return true;
    }

    public function afterValidation() : void {
        parent::afterValidation();

    }

}
