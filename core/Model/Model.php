<?php

namespace app\core\Model;

use app\core\Exceptions\UnDefinedColumnNameException;
use app\core\QueryBuilder\QueryBuilder;
use app\core\QueryBuilder\QueryBuilderInterface;
use Illuminate\Container\Container;
use PDO;

/**
 *
 */
abstract class Model implements ModelInterface
{

    /**
     * @var string
     */
    protected static string $table_name = '';

    /**
     * @var string
     */
    protected static string $primary_key_name = "id";

    protected bool $auto_incremented_primary_key = true;


    /**
     * @param QueryBuilderInterface $queryBuilder
     */
    public function __construct(
        protected PDO $db,
        protected QueryBuilderInterface $queryBuilder,
        protected Container             $container
    ) {
    }

    public static function primaryKeyName(): string
    {
        return static::$primary_key_name;
    }

    /**
     * @param string|null $orderBy
     * @return static[]
     */
    public static function all(string $orderBy=null): array
    {
        $records = Container::getInstance()->make(QueryBuilderInterface::class)->all(static::tableName(), $orderBy);
        return static::from2DArray($records);
    }

    public static function selectWhere(string $column, string $operator, float|bool|int|string|null $value, string $orderBy=null): array
    {
        $records = Container::getInstance()->make(QueryBuilderInterface::class)->selectWhere(static::tableName(), $column, $operator, $value, $orderBy);
        return static::from2DArray($records);
    }

    /**
     * @param array<array> $records
     * @return static[]
     */
    private static function from2DArray(array $records): array
    {
        $models =[];
        foreach ($records as $record) {
            $models[]=static::fromArray($record);
            unset($record); // free some space
        }
        return $models;
    }



    public static function fromArray(array $array):static
    {
        $model = container()->make(static::class);
        foreach ($array as $key => $value) {
            if(static::columnNameExists($key)) {
                $model->{$key}=$value;
            }
        }
        return $model;
    }

    /**
     * @param string $attribute
     * @param float|bool|int|string $value
     * @return $this
     * @throws UnDefinedColumnNameException
     */
    public function set(string $attribute, mixed $value): static
    {

        if (static::columnNameExists($attribute)) {
            $this->{$attribute} = $value;
        } else {
            throw new UnDefinedColumnNameException("Column $attribute is not defined in table " . static::tableName());
        }
        return $this;
    }

    /**
     * @param string $column
     * @return bool
     */
    public static function columnNameExists(string $column): bool
    {
        return in_array($column, static::columns(), true);
    }

    /**
     * @return string
     */
    public static function tableName(): string
    {
        return static::$table_name;
    }

    /**
     * @param string $attribute
     * @return string|int|bool|float|null
     */
    public function get(string $attribute): mixed
    {
        return $this->{$attribute} ?? null;
    }

    /**
     * @param string $attribute
     * @return static
     * @throws UnDefinedColumnNameException
     */
    /*public function delete(string $attribute): static
    {
        if (static::columnNameExists($attribute)) {
            $this->{$attribute} = null;
        } else {
            throw new UnDefinedColumnNameException("Column $attribute is not defined in table " . static::tableName());
        }
        return $this;
    }*/

    /**
     * Remove the Model data from both the memory and the database, but it does not unset the model variable.
     * <P> In other words, it sets all the Model attributes (columns) to null, and calls the save() method on the model.
     * @return static
     */
    public function destroy(): static
    {
        $columns = static::columns();
        foreach ($columns as $column) {
            $this->{$column} = null;
        }
        return $this->save();

    }

    /**
     * @return static
     */
    public function save(): static
    {
        // todo add update or insert
        $record = [];
        foreach (static::columns() as $column) {
            if(isset($this->{$column})) {
                $record[$column] = $this->{$column};
            }
        }

        $model = $this->queryBuilder->insert(static::tableName(), $record);
        $model= static::fromArray($model);
        foreach (static::columns() as $column) {
            $this->{$column}=$model->{$column};
        }
        return $model;
    }

    public static function find(int $primaryKey)
    {
        $result = static::selectWhere(static::$primary_key_name, '=', $primaryKey);
        if(count($result)==0) {
            return null;
        }
        return $result[0];
    }

    public static function massDelete(array $ids): bool
    {
        return container()->make(QueryBuilderInterface::class)
            ->massDelete(static::tableName(),$ids,static::$primary_key_name);
    }
    public function toArray():array{
        $modelArray=[];
        foreach (static::columns() as $column){
            if($this->get($column) instanceof ModelInterface){
                $modelArray[$column]=$this->get($column)->toArray();
            }else{
                $modelArray[$column]=$this->get($column);
            }
        }
        return $modelArray;
    }

    public static function columns() : array{
     return [];
    }
}
