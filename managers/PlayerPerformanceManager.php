<?php
namespace App\Managers;

use App\Config\Database;
use PDO;

class PlayerPerformanceManager extends AbstractManager
{
     public function __construct()
    {
        parent::__construct();
    }
    
    public function findPlayerById(int $id): ?Player
    {
        $query = $this->db->prepare("SELECT * FROM players WHERE id = :id");
        $query->execute(["id" => $id]);
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        $player = new Player($result["nickname"], $result["bio"], $result["portrait"], $result["team"]);
        $player->setId($result["id"]);

        return $player;
    }
    
    public function findPlayerPerformance(int $playerId): array
    {
        $query = $this->db->prepare("
            SELECT *
            FROM player_performance
            JOIN players ON players.id = player_performance.player
            WHERE player_performance.player = :players.id;

        ");
    
        $query->execute(["playerId" => $playerId]);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
    
        if (!$results) {
            return []; // signifie aucune performance trouvée, si je mettais null: Mauvais choix ici, car ça pourrait être mal interprété comme "joueur introuvable".
        }

        $performances = [];
        foreach ($results as $result) {
            $performance = new PlayerPerformance(
                $result["player"], 
                $result["game"], 
                $result["points"], 
                $result["assists"]
            );
            $performance->setId($result["id"]);

            $performances[] = $performance; 
        }
    }
    
    
    public function findPlayerTeam(int $playerId): ?TeamModel
    {
        $query = $this->db->prepare("
            SELECT team
            FROM players
            WHERE id = :playerId
        ");
    
        $query->execute(["playerId" => $playerId]);
        
        $result = $query->fetch(PDO::FETCH_ASSOC);
    
        if (!$result) {
            return null;
        }
    
        // On crée un objet TeamModel avec l'ID de l'équipe récupéré
        $team = new TeamModel("", "", new MediaModel(""), $result["team"]);
        
        return $team; // Retourne l'équipe du joueur
    }
    
        public function findPlayersInSameTeam(int $playerId): array
    {
        // Appel de la fonction pour obtenir l'équipe du joueur
        $team = $this->findPlayerTeam($playerId);
        
        // Si aucun résultat n'est trouvé pour l'équipe, retourner un tableau vide
        if (!$team) {
            return [];
        }
    
        // Préparation de la requête pour récupérer les joueurs de la même équipe
        $query = $this->db->prepare("
            SELECT p.*
            FROM players p
            WHERE p.team = :teamId
            AND p.id != :playerId
        ");
        
        // Exécution de la requête avec l'ID de l'équipe et du joueur
        $query->execute([
            "teamId" => $team->getId(),  // ID de l'équipe récupéré à partir de l'objet TeamModel
            "playerId" => $playerId
        ]);
        
        // Récupération des résultats
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        
        // Si aucun joueur trouvé, retourner un tableau vide
        if (!$results) {
            return [];
        }
    
        // Création des objets PlayerModel pour chaque joueur trouvé
        $players = [];
        foreach ($results as $result) {
            // Ici, on suppose que l'objet TeamModel a été récupéré correctement par la fonction précédente
            $team = new TeamModel("","",new MediaModel(""));  // On pourrait aussi récupérer ces données, si nécessaire
            $portrait = new MediaModel(""); // Initialiser le portrait si nécessaire
    
            // Création de l'objet PlayerModel pour chaque joueur
            $player = new PlayerModel(
                $result["nickname"],
                $result["bio"],
                $portrait,
                $team
            );
            
            $player->setId($result["id"]);
            $players[] = $player;
        }
    
        return $players; // Retourne tous les joueurs de la même équipe
}


    
    
}

// echo "<pre>";
// var_dump($players);
// echo "</pre>";

?>




construct (parent) ok 

findOneById ok 
findPlayerPerformance ok
findPlayerTeam (nécessaire pour celle qui suit?) ok
findPlayersInSameTeam

