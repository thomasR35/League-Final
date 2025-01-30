<?php

namespace App\Models;

class MediaModel
{
    private ?int $id = null;
    private string $url;
    private string $alt;

    public function __construct(string $url, string $alt = '', ?int $id = null)
    {
        $this->url = $url;
        $this->alt = $alt;
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getUrl(): string
    {
        return $this->url;
    }
    public function getAlt(): string
    {
        return $this->alt;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }
    public function setUrl(string $url): void
    {
        $this->url = $url;
    }
    public function setAlt(string $alt): void
    {
        $this->alt = $alt;
    }
}
