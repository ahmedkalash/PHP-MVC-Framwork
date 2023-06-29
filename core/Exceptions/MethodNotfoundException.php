<?php

namespace app\core\Exceptions;

class MethodNotfoundException extends \Exception
{

    /**
     * @param string $string
     */
    public function __construct(string $string)
    {
        parent::__construct($string);
    }
}