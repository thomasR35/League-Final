<?php

namespace App\Managers;

use App\Models\PlayerModel;
use App\Models\MediaModel;
use App\Models\TeamModel;
use PDO;

class PlayerManager extends AbstractManager
{
    public function getRandomPlayers(int $limit = 3): array
    {
        $query = $this->db->query("
            SELECT players.*, 
                   media.url AS portrait_url, 
                   media.alt AS portrait_alt, 
                   teams.name AS team_name, 
                   teams.description AS team_description, 
                   team_media.id AS team_logo_id,
                   team_media.url AS team_logo_url,
                   team_media.alt AS team_logo_alt
            FROM players
            JOIN media ON players.portrait = media.id
            JOIN teams ON players.team = teams.id
            JOIN media AS team_media ON teams.logo = team_media.id
            ORDER BY RAND()
            LIMIT $limit
        ");

        $players = [];

        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            //On transforme `team_logo` en un objet MediaModel
            $teamLogo = new MediaModel($data['team_logo_url'], $data['team_logo_alt'], $data['team_logo_id']);

            //On passe bien un MediaModel en troisième paramètre
            $data['team'] = new TeamModel(
                $data['team_name'],
                $data['team_description'],
                $teamLogo
            );

            //On passe directement les bonnes valeurs à MediaModel pour le portrait
            $data['portrait'] = new MediaModel($data['portrait_url'], $data['portrait_alt']);

            $players[] = new PlayerModel($data);
        }

        return $players;
    }
}
