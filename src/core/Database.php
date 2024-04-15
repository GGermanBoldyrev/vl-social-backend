<?php

namespace src\core;

use PDO;
use PDOStatement;
use src\interfaces\DatabaseInterface;

class Database implements DatabaseInterface
{
    private static ?PDO $pdo = null;

    public static function connect(array $config): void
    {
        if (self::$pdo === null) {
            $dsn = "mysql:host=" . $config['host'] . ";dbname=" . $config['dbname'];
            $username = $config['username'];
            $password = $config['password'];
            self::$pdo = new PDO($dsn, $username, $password);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        }
    }

    public static function query(string $sql, array $params = []): PDOStatement
    {
        $statement = self::$pdo->prepare($sql);
        $statement->execute($params);
        return $statement;
    }

    public static function getAll(string $table): false|array
    {
        $sql = "SELECT * FROM $table";
        $statement = self::query($sql);
        return $statement->fetchAll();
    }

    public static function getOne(string $table, array $params): false|array
    {
        $condition = "";
        $exec = [];
        foreach ($params as $key => $value) {
            $condition .= $key . " = :" . $key . " AND ";
            $exec[":$key"] = $value;
        }
        $condition = substr($condition, 0, -5);
        if ($condition == "") {
            $condition = "id=1";
        }
        $sql = "SELECT * FROM $table WHERE $condition";
        $statement = self::query($sql, $exec);
        return $statement->fetch();
    }

    public static function delete(string $table, array $params): bool
    {
        $condition = "";
        $exec = [];
        foreach ($params as $key => $value) {
            $condition .= $key . " = :" . $key . " AND ";
            $exec[":$key"] = $value;
        }
        $condition = substr($condition, 0, -5);
        if ($condition == "") {
            return false;
        }
        $sql = "DELETE FROM $table WHERE $condition";
        $statement = self::query($sql, $exec);
        return $statement->rowCount() > 0;
    }
}