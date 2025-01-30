<?php

namespace App\Models;

use App\Models\MediaModel;
use App\Models\TeamModel;

class PlayerModel
{
    private ?int $id = null;
    private string $nickname;
    private string $bio;
    private MediaModel $portrait;
    private TeamModel $team;
    private array $performances = [];

    public function __construct(array $data)
    {
        if (isset($data['id'])) {
            $this->setId($data['id']);
        }
        if (isset($data['nickname'])) {
            $this->setNickname($data['nickname']);
        }
        if (isset($data['bio'])) {
            $this->setBio($data['bio']);
        }
        if (isset($data['portrait']) && $data['portrait'] instanceof MediaModel) {
            $this->setPortrait($data['portrait']);
        }
        if (isset($data['team']) && $data['team'] instanceof TeamModel) {
            $this->setTeam($data['team']);
        }
        if (isset($data['performances']) && is_array($data['performances'])) {
            $this->setPerformances($data['performances']);
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getNickname(): string
    {
        return $this->nickname;
    }
    public function setNickname(string $nickname): void
    {
        $this->nickname = $nickname;
    }

    public function getBio(): string
    {
        return $this->bio;
    }
    public function setBio(string $bio): void
    {
        $this->bio = $bio;
    }

    public function getPortrait(): MediaModel
    {
        return $this->portrait;
    }
    public function setPortrait(MediaModel $portrait): void
    {
        $this->portrait = $portrait;
    }

    public function getTeam(): TeamModel
    {
        return $this->team;
    }
    public function setTeam(TeamModel $team): void
    {
        $this->team = $team;
    }

    public function getPerformances(): array
    {
        return $this->performances;
    }
    public function setPerformances(array $performances): void
    {
        $this->performances = $performances;
    }
    public function addPerformance(PlayerPerformanceModel $performance): void
    {
        $this->performances[] = $performance;
    }
}
