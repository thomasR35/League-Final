<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Managers\GameManager;

class MatchController extends BaseController
{
    private GameManager $gameManager;

    public function __construct(GameManager $gameManager)
    {
        parent::__construct();
        $this->gameManager = $gameManager;
    }

    public function index()
    {
        // Récupérer tous les matchs
        $matches = $this->gameManager->getAllGames();

        // Envoyer les données à la vue
        echo $this->twig->render('matches.twig', [
            'section_titles' => [
                'matches' => 'Tous les Matchs',
            ],
            'matches' => $matches
        ]);
    }
    public function show($matchId)
    {
        $match = $this->gameManager->getGameById($matchId);
        $performances = $this->gameManager->getMatchPerformances($matchId);

        echo $this->twig->render('match-details.twig', [
            'match' => $match,
            'performances' => $performances
        ]);
    }
}
