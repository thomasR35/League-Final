<?php

namespace App\Routes;

use App\Controllers\HomeController;
use App\Managers\PlayerManager;
use App\Config\Database;

class Router
{
    private PlayerManager $playerManager;

    public function __construct()
    {
        // Utilisation de la connexion unique de Database.php
        $db = Database::getInstance();
        $this->playerManager = new PlayerManager($db);
    }

    public function handleRequest()
    {
        $page = $_GET['page'] ?? 'home';

        switch ($page) {
            case 'home':
            default:
                $controller = new HomeController($this->playerManager);
                $controller->index();
                break;
        }
    }
}
