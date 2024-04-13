<?php

namespace src\core;

use PDO;
use src\interfaces\DatabaseInterface;

class Database implements DatabaseInterface
{
    private PDO $pdo;

    public function __construct($config) {
        $dsn = "mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'];
        $username = $config['username'];
        $password = $config['password'];

        $this->pdo = new PDO($dsn, $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getConnection(): PDO {
        return $this->pdo;
    }
}