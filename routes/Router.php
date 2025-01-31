<?php

namespace App\Routes;

use App\Controllers\HomeController;
use App\Managers\PlayerManager;
use App\Managers\TeamManager;
use App\Managers\GameManager;
use App\Config\Database;

class Router
{
    private PlayerManager $playerManager;
    private TeamManager $teamManager;
    private GameManager $gameManager;

    public function __construct()
    {
        // Utilisation de la connexion unique de Database.php
        $db = Database::getInstance();
        $this->playerManager = new PlayerManager($db);
        $this->teamManager = new TeamManager($db);
        $this->gameManager = new GameManager($db); // 🔥 Ajout du GameManager
    }

    public function handleRequest()
    {
        $page = $_GET['page'] ?? 'home';

        switch ($page) {
            case 'home':
            default:
                $controller = new HomeController($this->playerManager, $this->teamManager, $this->gameManager);
                $controller->index();
                break;
        }
    }
}
