<?php

namespace App\Models;

class TeamModel
{
    // Propriétés correspondant à la structure de la table teams
    private ?int $id;
    private string $name;
    private string $description;
    private MediaModel $logo;

    // Constructeur
    public function __construct(string $name, string $description, MediaModel $logo, ?int $id = null)
    {
        $this->name = $name;
        $this->description = $description;
        $this->logo = $logo;
        $this->id = $id;
    }
    // Getters
    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getLogo(): MediaModel
    {
        return $this->logo;
    }

    // Setters
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function setLogo(MediaModel $logo): void
    {
        $this->logo = $logo;
    }
}
