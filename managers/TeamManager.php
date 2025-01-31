<?php

namespace App\Managers;

use PDO;

class TeamManager extends AbstractManager
{
    public function getFeaturedTeam(): ?array
    {
        $stmt = $this->db->query("
        SELECT t.*, m.url AS image_url
        FROM teams t
        LEFT JOIN media m ON t.logo = m.id
        ORDER BY (SELECT COUNT(*) FROM games g WHERE g.winner = t.id) DESC
        LIMIT 1
    ");
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
    public function getAllTeams(): array
    {
        $stmt = $this->db->query("
        SELECT t.id, t.name, t.description, m.url AS logo_url, m.alt AS logo_alt
        FROM teams t
        INNER JOIN media m ON t.logo = m.id
        ORDER BY t.name ASC
    ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getTeamById($teamId): ?array
    {
        $stmt = $this->db->prepare("
        SELECT t.id, t.name, t.description, m.url AS logo_url, m.alt AS logo_alt
        FROM teams t
        LEFT JOIN media m ON t.logo = m.id
        WHERE t.id = :teamId
    ");
        $stmt->bindValue(':teamId', $teamId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPlayersByTeam($teamId): array
    {
        $stmt = $this->db->prepare("
        SELECT p.id, p.nickname, m.url AS portrait_url, m.alt AS portrait_alt
        FROM players p
        LEFT JOIN media m ON p.portrait = m.id
        WHERE p.team = :teamId
        LIMIT 3
    ");
        $stmt->bindValue(':teamId', $teamId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
