<?php

namespace app\core\Validator;

use app\core\QueryBuilder\QueryBuilderInterface;
use Illuminate\Container\Container;

class Validator implements ValidatorInterface
{
    private static function snackCaseToNormalText(string $snackCase){
        $str= str_replace('_',' ',$snackCase);
        return ucfirst($str);
    }

    public static function notNull(float|bool|int|string|null $var, string $name, string $errorMessage = null): bool|array
    {
        $presentationName = static::snackCaseToNormalText($name);
        return is_null($var)? [
            $name=>$errorMessage ?? "$presentationName is required"
        ]:true;
    }

    public static function notEmpty(string $var, string $name, string $errorMessage = null): bool|array
    {
         $presentationName = static::snackCaseToNormalText($name);

         return (trim($var)=='')? [
            $name=>$errorMessage ?? "$presentationName is required"
        ]:true;

    }

    public static function required(string $var, string $name, string $errorMessage = null): bool|array
    {
        return (static::notNull($var,$name,$errorMessage)===true )? true:static::notEmpty($var,$name,$errorMessage);
    }


    public static function maxLength(bool|int|string $var, int $maxLength, string $name, string $errorMessage = null): bool|array
    {
        $presentationName = static::snackCaseToNormalText($name);
        return strlen((string) $var)>$maxLength ? [
            $name=>$errorMessage ?? "$presentationName is too long"
        ]:true;
    }

    public static function float(float|string $var, int $integerLength, int $fractionLength,string $name, string $errorMessage = null): bool|array
    {
        $var= floatval($var);
        $presentationName = static::snackCaseToNormalText($name);
        $value = (string) $var;
        $parts = explode('.', $value);

        $integerPart = $parts[0];
        $fractionPart = $parts[1] ?? '';

        $isValid = strlen($integerPart) <= $integerLength && strlen($fractionPart) <= $fractionLength;


        return $isValid ? true:[$name => $errorMessage ?? "Invalid value for $presentationName."];

    }

    public static function number(mixed $var, string $name, string $errorMessage = null): bool|array
    {
        $presentationName = static::snackCaseToNormalText($name);
        return is_numeric($var) ? true:[
            $name=>$errorMessage ?? "$presentationName must be a number"
        ];
    }


    public static function minLength(float|bool|int|string $var, int $minLength, string $name, string $errorMessage = null): bool|array
    {
        $presentationName = static::snackCaseToNormalText($name);
        return strlen((string) $var)>$minLength ? [
            $name=>$errorMessage ?? "$presentationName is too short"
        ]:true;

    }

    public static function oneOf(float|bool|int|string|null $var, array $choices, string $name, string $errorMessage = null): bool|array
    {
         $presentationName = static::snackCaseToNormalText($name);
         return in_array($var, $choices) ? true:[
            $name=>$errorMessage ?? "$presentationName is not supported"
        ];
    }

    public static function unique(string|int|float|bool|null $value,string $table, string $column, string $name, string $errorMessage = null): bool|array
    {
        $presentationName = static::snackCaseToNormalText($name);
        $unique = Container::getInstance()->make(QueryBuilderInterface::class)->unique($value,$table,$column);
        return $unique?true:[
            $name=>$errorMessage ?? "$presentationName is used. Enter another one"
        ];
    }
}