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
}
