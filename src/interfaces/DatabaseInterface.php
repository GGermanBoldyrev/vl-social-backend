<?php

namespace src\interfaces;

use PDO;

interface DatabaseInterface
{
    public function getConnection(): PDO;
}