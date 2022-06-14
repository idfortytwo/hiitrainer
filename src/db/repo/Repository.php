<?php

namespace DB\Repo;

use PDOStatement;

use DB\Connection;

abstract class Repository {
    protected Connection $database;

    public function __construct() {
        $this->database = new Connection();
    }

    protected function getQuery(string $statement): PDOStatement {
        return $this->database->connect()->prepare($statement);
    }
}
