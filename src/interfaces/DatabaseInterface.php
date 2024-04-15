<?php

namespace src\interfaces;

use PDOStatement;

interface DatabaseInterface
{
    public static function connect(array $config): void;

    public static function query(string $sql, array $params = []): PDOStatement;

    public static function getAll(string $table): false | array;

    public static function getOne(string $table, array $params): false | array;
}