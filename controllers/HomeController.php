<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Managers\PlayerManager;

class HomeController extends BaseController
{
    private PlayerManager $playerManager;

    public function __construct(PlayerManager $playerManager)
    {
        parent::__construct();
        $this->playerManager = $playerManager;
    }

    public function index()
    {
        // Récupérer 3 joueurs aléatoires depuis la base de données
        $players = $this->playerManager->getRandomPlayers(3);

        // Rendu du template avec les données nécessaires
        echo $this->twig->render('home.twig', [
            'section_titles' => [
                'teams' => 'La team à la une',
                'players' => 'Les players à la une',
                'matches' => 'Le Dernier Match'
            ],
            'players' => $players
        ]);
    }
}
