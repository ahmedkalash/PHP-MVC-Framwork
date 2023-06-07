<?php

namespace app\core\Model;

use app\core\Exceptions\UnDefinedColumnNameException;
use Closure;

interface ModelInterface
{

    /**
     * Finds a record in the table by it primary key.
     * @param int $primary_key
     * @return static|null
     */
    public static function find(int $primary_key): ?static;

    /** Columns names
     * @return array<string> <p> An array that contains the column names as its values
     */
    public function columns(): array;

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
     * Sets the table name
     * @param string $table_name
     * @return $this
     */
    public function setTableName(string $table_name): static;

    /**
     * Gets the table name
     * @return string
     */
    public function tableName(): string;

    /**
     * Gets the value of an attribute.
     * @param string $attribute
     * @return string|int|bool|float|null
     */
    public function get(string $attribute): string|int|bool|float|null;

    /**
     * Gets all the Model data as an array.
     * @return array<string, bool|float|int|null|string>
     */
    public function all(): array;

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
    public function columnNameExists(string $column): bool;

    /**
     * Returns the name of the table primary key.
     * @return string
     */
    public function primaryKeyName(): string;

    /**
     * Perform a transaction.
     * @param Closure $closure
     * @return mixed
     */
    public function transaction(Closure $closure): mixed;


}
