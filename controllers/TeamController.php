<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Managers\TeamManager;

class TeamController extends BaseController
{
    private TeamManager $teamManager;

    public function __construct(TeamManager $teamManager)
    {
        parent::__construct();
        $this->teamManager = $teamManager;
    }

    public function index()
    {
        // Récupérer toutes les équipes depuis la BDD
        $teams = $this->teamManager->getAllTeams();

        // Affichage du template
        echo $this->twig->render('teams.twig', [
            'section_titles' => [
                'teams' => 'Les Teams de la League',
            ],
            'teams' => $teams
        ]);
    }
    public function show($teamId)
    {
        $team = $this->teamManager->getTeamById($teamId);
        $players = $this->teamManager->getPlayersByTeam($teamId);

        echo $this->twig->render('team-details.twig', [
            'team' => $team,
            'players' => $players
        ]);
    }
}
