<?php

require_once 'src/db/Connection.php';

use JetBrains\PhpStorm\Pure;

abstract class Repository {
    protected Connection $database;

    #[Pure] public function __construct() {
        $this->database = new Connection();
    }

    protected function getQuery(string $statement) : PDOStatement {
        return $this->database->connect()->prepare($statement);
    }
}
