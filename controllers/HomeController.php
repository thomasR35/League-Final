<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Managers\PlayerManager;
use App\Managers\TeamManager;
use App\Managers\GameManager;
use Exception;

class HomeController extends BaseController
{
    private PlayerManager $playerManager;
    private TeamManager $teamManager;
    private GameManager $gameManager;

    public function __construct(PlayerManager $playerManager, TeamManager $teamManager, GameManager $gameManager)
    {
        parent::__construct();
        $this->playerManager = $playerManager;
        $this->teamManager = $teamManager;
        $this->gameManager = $gameManager;
    }

    public function index()
    {
        try {
            // Récupérer 3 joueurs aléatoires depuis la base de données
            $players = $this->playerManager->getRandomPlayers(3) ?? [];

            // Récupérer une équipe mise en avant
            $featured_team = $this->teamManager->getFeaturedTeam();

            // Récupérer le dernier match
            $lastGame = $this->gameManager->getLastGame();

            // Vérifier que l'équipe mise en avant existe
            $featured_team_players = [];
            if ($featured_team) {
                $featured_team_players = $this->playerManager->getPlayersByTeam($featured_team['id'], 3);
            } else {
                $featured_team = null;
            }

            // Rendu du template avec les données nécessaires
            echo $this->twig->render('home.twig', [
                'section_titles' => [
                    'featured_team' => 'La Team à la Une',
                    'players' => 'Les Players à la Une',
                    'matches' => 'Le Dernier Match'
                ],
                'featured_team' => $featured_team,
                'featured_team_players' => $featured_team_players,
                'players' => $players,
                'matches' => $lastGame ? [$lastGame] : []
            ]);
        } catch (Exception $e) {
            // Gérer les erreurs et afficher un message approprié
            echo "Une erreur est survenue : " . $e->getMessage();
        }
    }
}
