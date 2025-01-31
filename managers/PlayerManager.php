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
    public function getPlayersByTeam(int $teamId, int $limit = 3): array
    {
        // Construction de la requête sans paramètre LIMIT
        $stmt = $this->db->prepare("
        SELECT p.id, p.nickname, m.url AS image_url
        FROM players p
        LEFT JOIN media m ON p.portrait = m.id
        WHERE p.team = :team_id
        ORDER BY RAND()
        LIMIT $limit
    ");

        $stmt->bindValue(':team_id', $teamId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllPlayers(): array
    {
        $stmt = $this->db->query("
        SELECT p.id, p.nickname, m.url AS portrait_url, m.alt AS portrait_alt, 
               t.name AS team_name, tm.url AS team_logo_url, tm.alt AS team_logo_alt
        FROM players p
        INNER JOIN media m ON p.portrait = m.id
        LEFT JOIN teams t ON p.team = t.id
        LEFT JOIN media tm ON t.logo = tm.id
        ORDER BY p.nickname ASC
    ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getPlayerById($playerId): ?array
    {
        $stmt = $this->db->prepare("
        SELECT p.id, p.nickname, m.url AS portrait_url, m.alt AS portrait_alt, 
               t.id AS team_id, t.name AS team_name, tm.url AS team_logo_url, tm.alt AS team_logo_alt
        FROM players p
        LEFT JOIN media m ON p.portrait = m.id
        LEFT JOIN teams t ON p.team = t.id
        LEFT JOIN media tm ON t.logo = tm.id
        WHERE p.id = :playerId
    ");
        $stmt->bindValue(':playerId', $playerId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPlayerPerformances($playerId): array
    {
        $stmt = $this->db->prepare("
        SELECT g.date, t.name AS opponent, pp.points, pp.assists, 
               CASE WHEN g.winner = p.team THEN 'Oui' ELSE 'Non' END AS victory
        FROM player_performance pp
        JOIN games g ON pp.game = g.id
        JOIN players p ON pp.player = p.id
        JOIN teams t ON (g.team_1 = t.id OR g.team_2 = t.id) AND t.id != p.team
        WHERE pp.player = :playerId
        ORDER BY g.date DESC
    ");
        $stmt->bindValue(':playerId', $playerId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTeammates($teamId, $playerId): array
    {
        $stmt = $this->db->prepare("
        SELECT p.id, p.nickname, m.url AS portrait_url, m.alt AS portrait_alt
        FROM players p
        LEFT JOIN media m ON p.portrait = m.id
        WHERE p.team = :teamId AND p.id != :playerId
        LIMIT 2
    ");
        $stmt->bindValue(':teamId', $teamId, PDO::PARAM_INT);
        $stmt->bindValue(':playerId', $playerId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
