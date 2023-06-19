<?php

namespace app\core\Model;

use app\core\Exceptions\UnDefinedColumnNameException;
use Closure;

interface ModelInterface
{


    /** Columns names
     * @return array<string> <p> An array that contains the column names as its values
     */
    public static function columns(): array;

    /**
     * Sets a value to an attribute.
     * * <P> Note that it does not Persist the data into the database. You need to call
     * the save() method Persist the data.
     * @param string $attribute
     * @param string|int|bool|float $value
     * @return $this
     * @throws UnDefinedColumnNameException
     */
    public function set(string $attribute, string|int|bool|float $value): static;


    /**
     * Gets the table name
     * @return string
     */
    public static function tableName(): string;

    /**
     * Gets the value of an attribute.
     * @param string $attribute
     * @return string|int|bool|float|null
     */
    public function get(string $attribute): string|int|bool|float|null;


    /**
     * Deletes the value of an attribute (sets it to null).
     * * <P> Note that it does not Persist the data into the database. You need to call
     * the save() method Persist the data.
     * @param string $attribute
     * @return $this
     */
    public function delete(string $attribute): static;

    /**
     * Remove the Model data from both the memory and the database, but it does not unset the model variable.
     * <P> In other words, it sets all the Model attributes (columns) to null, and calls the save() method on the model
     * to persist the data into the database.
     * @return static
     */
    public function destroy(): static;

    /**
     * Persist the data into the database
     * @return static
     */
    public function save(): static;

    /**
     * Checks if column name exists.
     * @param string $column
     * @return bool
     */
    public static function columnNameExists(string $column): bool;

    /**
     * Returns the name of the table primary key.
     * @return string
     */
    public static function primaryKeyName(): string;


    /**
     * Makes a model from an array that has the column name as the key and the value as its value
     * @param array<string, string|int|bool|float|null> $array
     * @return static
     */
    public static function fromArray(array $array):static;



    /**
     * Gets all records from the table
     * @param string|null $orderBy
     * @return static[]
     */
    public static function all(string $orderBy=null): array;


    /**
     * @param string $table
     * @param string $column
     * @param string $operator
     * @param float|bool|int|string|null $value
     * @param string|null $orderBy
     * @return static[]
     */
    public static function selectWhere(string $column, string $operator, float|bool|int|string|null $value, string $orderBy=null): array;






    public static function find(int $primaryKey);


}
