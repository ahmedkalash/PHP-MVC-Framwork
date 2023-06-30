<?php
declare(strict_types=1);

namespace app\requests;


class AddProductRequest extends \app\core\Request\Request
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
        $errorMessage = null;

        if(is_null($name)){
            $errorMessage = "Name is required";
        }


        return $errorMessage ? [$field_name => $errorMessage] : true;
    }

    private function validateSku()
    {
        $field_name = 'sku';
        $sku = $this->input($field_name);
        $errorMessage = null;

        if(is_null($sku)){
            $errorMessage = "SKU is required";
        }

        return $errorMessage ? [$field_name => $errorMessage] : true;
    }

    private function validatePrice()
    {
         $field_name = 'price';
        $price = $this->input($field_name);
        $errorMessage = null;

        if(is_null($price)){
            $errorMessage = "Price is required";
        }

        return $errorMessage ? [$field_name => $errorMessage] : true;
    }
    private function validateProductType()
    {
        $field_name = 'product_type';
        $productType = $this->input($field_name);
        $errorMessage = null;

        if(is_null($productType)){
            $errorMessage = "Product type is required";
        }

        return $errorMessage ? [$field_name => $errorMessage] : true;
    }


}