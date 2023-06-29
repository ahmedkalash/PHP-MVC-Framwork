<?php
declare(strict_types=1);

namespace app\requests;

use app\core\Request\Request;

class RegisterRequest extends Request
{

    public function validate(): bool|array
    {
        $errors = [];
        if ($this->validateFirstName() !== true) {
            $errors = array_merge($errors, $this->validateFirstName());
        }
        if ($this->validateLastName() !== true) {
            $errors = array_merge($errors, $this->validateLastName());
        }
        if (true) {
            // call another validation function and update the array of errors.
        }

        return count($errors) ? $errors : true;
    }

    public function validateFirstName(): bool|array
    {

        $field_name = 'first_name';
        $first_name = $this->input($field_name);
        $errorMessage = null;

        if (is_null($first_name)) {
            $errorMessage = "First name is required";
        } elseif (strlen($first_name) <= 3) {
            $errorMessage = "First name Must be more that three characters.";
        }

        return $errorMessage ? [$field_name => $errorMessage] : true;
    }

    public function validateLastName(): bool|array
    {

        $field_name = 'last_name';
        $first_name = $this->input($field_name);
        $errorMessage = null;

        if (is_null($first_name)) {
            $errorMessage = "Last name Is required";
        } elseif (strlen($first_name) <= 3) {
            $errorMessage = "Last name Must be more that three characters.";
        }

        return $errorMessage ? [$field_name => $errorMessage] : true;
    }
}
