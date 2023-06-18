<?php

namespace app\core\Model;

use app\core\Exceptions\UnDefinedColumnNameException;
use PDO;

/**
 *
 */
abstract class Model implements ModelInterface
{

    /**
     * @var string
     */
    protected string $table_name = '';

    /**
     * @var string
     */
    protected string $primary_key_name = "id";


    /**
     * @param PDO $db
     */
    public function __construct(
        public PDO $db
    ) {
    }


    /**
     * @param string $attribute
     * @param float|bool|int|string $value
     * @return $this
     * @throws UnDefinedColumnNameException
     */
    public function set(string $attribute, float|bool|int|string $value): static
    {

        if ($this->columnNameExists($attribute)) {
            $this->{$attribute} = $value;
        } else {
            throw new UnDefinedColumnNameException("Column $attribute is not defined in table $this->table_name");
        }
        return $this;
    }


    /**
     * @param string $attribute
     * @return string|int|bool|float|null
     */
    public function get(string $attribute): string|int|bool|float|null
    {
        return $this->{$attribute} ?? null;
    }

    /**
     * @param string $column
     * @return bool
     */
    public function columnNameExists(string $column): bool
    {
        return in_array($column, $this->columns(), true);
    }

    /**
     * @param string $table_name
     * @return $this
     */
    public function setTableName(string $table_name): static
    {
        $this->table_name = $table_name;
        return $this;
    }

    /**
     * @return string
     */
    public function tableName(): string
    {
        return $this->table_name;
    }


    /**
     * @return array<string,bool|float|int|null|string>
     */
    public function all(): array
    {
        $columns = $this->columns();
        $record = [];
        foreach ($columns as $column) {
            $record[$column] = $this->{$column} ?? null;
        }
        return $record;
    }

    /**
     * @param string $attribute
     * @return static
     * @throws UnDefinedColumnNameException
     */
    public function delete(string $attribute): static
    {
        if ($this->columnNameExists($attribute)) {
            $this->{$attribute} = null;
        } else {
            throw new UnDefinedColumnNameException("Column $attribute is not defined in table $this->table_name");
        }
        return $this;
    }

    /**
     * Remove the Model data from both the memory and the database, but it does not unset the model variable.
     * <P> In other words, it sets all the Model attributes (columns) to null, and calls the save() method on the model.
     * @return static
     */
    public function destroy(): static
    {
        $columns = $this->columns();
        foreach ($columns as $column) {
            $this->{$column} = null;
        }
        return $this->save();

    }


    public function primaryKeyName(): string
    {
        return $this->primary_key_name;
    }


    /**
     * @return static
     */
    public function save(): static
    {
        return $this;
        // TODO: Implement save() method.
    }

    public function transaction(\Closure $closure): mixed
    {
        // TODO: Implement transaction() method.
    }

    public static function find(int $primary_key): ?static
    {
        // TODO: Implement find() method.
    }


}
