<?php

require_once "config.php";

class Connection {
    private string $username;
    private string $password;
    private string $host;
    private string $database;

    public function __construct() {
        $this->host     = HOST;
        $this->database = DATABASE;
        $this->username = USERNAME;
        $this->password = PASSWORD;
    }

    public function connect() : PDO {
        $conn = new PDO(
            "pgsql:host=$this->host;port=5432;dbname=$this->database",
            $this->username,
            $this->password,
            ["sslmode"  => "prefer"]
        );
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
}
