<?php

namespace App\Models;

use \DateTime;

class GameModel
{
    private ?int $id = null;
    private string $name;
    private DateTime $date;
    private TeamModel $team_1;
    private TeamModel $team_2;
    private TeamModel $winner;

    public function __construct(?int $id, string $name, DateTime $date, TeamModel $team_1, TeamModel $team_2, TeamModel $winner)
    {
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
        $this->team_1 = $team_1;
        $this->team_2 = $team_2;
        $this->winner = $winner;
    }

    /*-------------------- ID --------------------*/
    public function getId(): int
    {
        return $this->id;
    }
    public function setId($id): void
    {
        $this->id = $id;
    }
    /*------------------- Name -------------------*/
    public function getName(): string
    {
        return $this->name;
    }
    public function setName($name): void
    {
        $this->name = $name;
    }
    /*------------------- Date -------------------*/
    public function getDate(): DateTime
    {
        return $this->date;
    }
    public function setDate($date): void
    {
        $this->date = $date;
    }
    /*------------------ Team 1 ------------------*/
    public function getTeam1(): TeamModel
    {
        return $this->team_1;
    }
    public function setTeam1(TeamModel $team_1): void
    {
        $this->team_1 = $team_1;
    }
    /*------------------ Team 2 ------------------*/
    public function getTeam2(): TeamModel
    {
        return $this->team_2;
    }
    public function setTeam2(TeamModel $team_2): void
    {
        $this->team_2 = $team_2;
    }
    /*------------------ Winner ------------------*/
    public function getWinner(): TeamModel
    {
        return $this->winner;
    }
    public function setWinner(TeamModel $winner): void
    {
        $this->winner = $winner;
    }
}
