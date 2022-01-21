<?php

namespace DB\Repo;

use JetBrains\PhpStorm\Pure;
use PDOStatement;

use DB\Connection;

abstract class Repository {
    protected Connection $database;

    #[Pure] public function __construct() {
        $this->database = new Connection();
    }

    protected function getQuery(string $statement) : PDOStatement {
        return $this->database->connect()->prepare($statement);
    }
}
