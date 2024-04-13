<?php

use src\core\Database;

$config = require "config.php";
$db = new Database($config);
$router = new Router();