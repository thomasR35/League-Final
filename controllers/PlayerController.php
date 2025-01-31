<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Managers\PlayerManager;

class PlayerController extends BaseController
{
    private PlayerManager $playerManager;

    public function __construct(PlayerManager $playerManager)
    {
        parent::__construct();
        $this->playerManager = $playerManager;
    }

    public function index()
    {
        // Récupérer tous les joueurs depuis la BDD
        $players = $this->playerManager->getAllPlayers();

        // Affichage du template
        echo $this->twig->render('players.twig', [
            'section_titles' => [
                'players' => 'Les Players de la League',
            ],
            'players' => $players
        ]);
    }
    public function show($playerId)
    {
        $player = $this->playerManager->getPlayerById($playerId);
        $performances = $this->playerManager->getPlayerPerformances($playerId);
        $teammates = $this->playerManager->getTeammates($player['team_id'], $playerId);

        echo $this->twig->render('player-details.twig', [
            'player' => $player,
            'performances' => $performances,
            'teammates' => $teammates
        ]);
    }
}
