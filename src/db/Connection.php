<?php

namespace DB;

use PDO;
use Config;

class Connection {
    private string $username;
    private string $password;
    private string $host;
    private string $port;
    private string $database;

    public function __construct() {
        $config = (new Config())->getConnectionCredentials();
        $this->host     = $config['HOST'];
        $this->port     = $config['PORT'];
        $this->database = $config['DATABASE'];
        $this->username = $config['USERNAME'];
        $this->password = $config['PASSWORD'];
    }

    public function connect(): PDO {
        $conn = new PDO(
            "pgsql:host=$this->host;port=$this->port;dbname=$this->database",
            $this->username,
            $this->password,
            ["sslmode"  => "prefer"]
        );

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
}
