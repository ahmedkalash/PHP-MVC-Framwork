<?php

namespace app\core\Validator;

interface ValidatorInterface
{
    public static function notNull(int|string|float|bool|null|array $var, string $name, string $errorMessage=null):bool|array;
    public static function notEmpty(string $var, string $name, string $errorMessage=null):bool|array;
    public static function maxLength(int|string|bool $var, int $maxLength ,string $name, string $errorMessage=null):bool|array;
    public static function minLength(int|string|float|bool $var, int $minLength ,string $name, string $errorMessage=null):bool|array;

    public static function oneOf(int|string|float|bool|null $var, array $choices,string $name, string $errorMessage=null):bool|array;

    public static function required(string|null $var, string $name, string $errorMessage = null): bool|array;
    public static function float(float|string $var, int $integerLength, int $fractionLength,string $name, string $errorMessage = null): bool|array;
    public static function number(mixed $var, string $name, string $errorMessage = null): bool|array;
    public static function unique(string|int|float|bool|null $value,string $table, string $column, string $name, string $errorMessage = null): bool|array;
}