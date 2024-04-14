<?php

/*delete after*/
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
/*delete after*/

require "../vendor/autoload.php";

use src\controllers\PostController;
use src\core\Database;
use src\core\Router;
use src\enums\HttpMethod;

$config = require "../config.php";
//$db = new Database($config);
$router = new Router();

/*Routes*/
$router->addRoute(HttpMethod::GET, "/posts", [PostController::class, 'index']);

/*Enter point*/
$router->route($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);