<?php

/*delete after*/
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
/*delete after*/

require "../vendor/autoload.php";

use src\controllers\LoginController;
use src\controllers\PostController;
use src\controllers\ProfileController;
use src\core\Database;
use src\core\Router;
use src\enums\HttpMethod;
use src\controllers\RegisterController;

$config = require "../config.php";
Database::connect($config);
$router = new Router();

/*Routes*/
$router->addRoute(HttpMethod::GET, "/posts", [PostController::class, 'index']);
$router->addRoute(HttpMethod::GET, "/user/posts", [PostController::class, 'userPosts']);

$router->addRoute(HttpMethod::GET, "/post", [PostController::class, 'show']);
$router->addRoute(HttpMethod::DELETE, "/post", [PostController::class, 'destroy']);
$router->addRoute(HttpMethod::POST, "/post", [PostController::class, 'store']);

$router->addRoute(HttpMethod::POST, "/register", [RegisterController::class, 'store']);
$router->addRoute(HttpMethod::POST, "/login", [LoginController::class, 'store']);
$router->addRoute(HttpMethod::POST, "/logout", [LoginController::class, 'logout']);

$router->addRoute(HttpMethod::GET, "/profile", [ProfileController::class, 'show']);

/*Enter point*/
$router->route($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);