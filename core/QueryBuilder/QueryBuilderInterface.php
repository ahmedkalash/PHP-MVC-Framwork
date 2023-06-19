<?php
declare(strict_types=1);
namespace app\core\QueryBuilder;

interface QueryBuilderInterface
{
    public function all(string $table, string $orderBy=null): array;
    public function selectWhere(string $table, string $column, string $operator, string|int|float|bool|null $value, string $orderBy=null): array;
    public function insert(string $table, array $record);
    public function delete();


}