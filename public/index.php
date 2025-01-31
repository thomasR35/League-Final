<?php
require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../routes/Router.php';

use App\Routes\Router;
use App\Controllers\MatchController;


$router = new Router();
$router->handleRequest();
