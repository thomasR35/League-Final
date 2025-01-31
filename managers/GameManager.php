<?php

namespace App\Managers;

use App\Models\GameModel;
use App\Models\TeamModel;
use App\Models\MediaModel;
use DateTime;
use PDO;

class GameManager extends AbstractManager
{
    /**
     * Récupère le dernier match joué
     */
    public function getLastGame(): ?GameModel
    {
        $stmt = $this->db->query("
            SELECT 
                g.id, g.name, g.date, g.winner AS winner_id,
                t1.id AS team1_id, t1.name AS team1_name, t1.description AS team1_description, 
                t1_media.id AS team1_logo_id, t1_media.url AS team1_logo_url, t1_media.alt AS team1_logo_alt,
                t2.id AS team2_id, t2.name AS team2_name, t2.description AS team2_description,
                t2_media.id AS team2_logo_id, t2_media.url AS team2_logo_url, t2_media.alt AS team2_logo_alt,
                w.id AS winner_team_id, w.name AS winner_name, w.description AS winner_description,
                w_media.id AS winner_logo_id, w_media.url AS winner_logo_url, w_media.alt AS winner_logo_alt
            FROM games g
            INNER JOIN teams t1 ON g.team_1 = t1.id
            INNER JOIN media t1_media ON t1.logo = t1_media.id
            INNER JOIN teams t2 ON g.team_2 = t2.id
            INNER JOIN media t2_media ON t2.logo = t2_media.id
            LEFT JOIN teams w ON g.winner = w.id
            LEFT JOIN media w_media ON w.logo = w_media.id
            ORDER BY g.date DESC
            LIMIT 1
        ");

        $gameData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$gameData) {
            return null;
        }

        // Création des objets TeamModel pour chaque équipe
        $team1 = new TeamModel(
            $gameData['team1_name'],
            $gameData['team1_description'],
            new MediaModel($gameData['team1_logo_url'], $gameData['team1_logo_alt'], $gameData['team1_logo_id'])
        );

        $team2 = new TeamModel(
            $gameData['team2_name'],
            $gameData['team2_description'],
            new MediaModel($gameData['team2_logo_url'], $gameData['team2_logo_alt'], $gameData['team2_logo_id'])
        );

        // Gestion du gagnant (peut être null)
        $winner = null;
        if (!empty($gameData['winner_team_id'])) {
            $winner = new TeamModel(
                $gameData['winner_name'],
                $gameData['winner_description'],
                new MediaModel($gameData['winner_logo_url'], $gameData['winner_logo_alt'], $gameData['winner_logo_id'])
            );
        }

        // Création de l'objet GameModel
        return new GameModel(
            $gameData['id'],
            $gameData['name'],
            new DateTime($gameData['date']),
            $team1,
            $team2,
            $winner
        );
    }
}
