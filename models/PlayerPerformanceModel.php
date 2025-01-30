<?php

namespace App\Models;

class PlayerPerformanceModel
{
    private ?int $id = null;

    public function __construct(private PlayerModel $player, private GameModel $game, private int $points, private int $assists) {}

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getPlayer(): PlayerModel
    {
        return $this->player;
    }

    public function setPlayer(PlayerModel $player): void
    {
        $this->player = $player;
    }

    public function getGame(): GameModel
    {
        return $this->game;
    }

    public function setGame(GameModel $game): void
    {
        $this->game = $game;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function setPoints(int $points): void
    {
        $this->points = $points;
    }

    public function getAssists(): int
    {
        return $this->assists;
    }

    public function setAssists(int $assists): void
    {
        $this->assists = $assists;
    }
}
