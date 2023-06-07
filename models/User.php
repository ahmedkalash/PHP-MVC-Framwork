<?php

namespace app\models;

class User extends \app\core\Model\Model
{

    protected int $id;
    protected string $first_name;
    protected string $last_name;

    protected string $email;
    protected string $password;


    protected string $table_name = "users";

    /**
     * @inheritDoc
     */
    public function columns(): array
    {
        return ["id", "first_name", "last_name", "email", "password"];
    }
}
