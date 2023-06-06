<?php

namespace app\core\Model;

class Model implements ModelInterface
{
    public function __construct(
        public \PDO $db
    ) {
    }


}
