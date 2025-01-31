<?php

namespace App\Routes;

use App\Controllers\HomeController;
use App\Managers\PlayerManager;
use App\Controllers\PlayerController;
use App\Managers\TeamManager;
use App\Controllers\TeamController;
use App\Managers\GameManager;
use App\Controllers\MatchController;
use App\Config\Database;

class Router
{
    private PlayerManager $playerManager;
    private TeamManager $teamManager;
    private GameManager $gameManager;
    private MatchController $matchController;

    public function __construct()
    {
        // Connexion à la BDD
        $db = Database::getInstance();
        $this->playerManager = new PlayerManager($db);
        $this->teamManager = new TeamManager($db);
        $this->gameManager = new GameManager($db);
        $this->matchController = new MatchController($this->gameManager);
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
            case 'matches':
                $this->matchController->index();
                break;
            case 'teams':
                $controller = new TeamController($this->teamManager);
                $controller->index();
                break;
            case 'players':
                $controller = new PlayerController($this->playerManager);
                $controller->index();
                break;
            case 'player-details':
                $controller = new PlayerController($this->playerManager);
                $controller->show($_GET['id']);
                break;
            case 'team-details':
                $controller = new TeamController($this->teamManager, $this->playerManager);
                $controller->show($_GET['id']);
                break;
            case 'match-details':
                $controller = new MatchController($this->gameManager);
                $controller->show($_GET['id']);
                break;
        }
    }
}
