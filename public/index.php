<?php
require __DIR__ . '/../vendor/autoload.php';

use App\Routes\Router;

$router = new Router();
$router->handleRequest();
