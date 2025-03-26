<?php

namespace App\Domain\Player;

use App\Domain\Enum\PlayerRole;

class Player
{
    public function __construct(
        private string     $id,
        private string     $name,
        private PlayerRole $role,
        private bool       $isHost = false,
        private bool       $isAlive = true,
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRole(): PlayerRole
    {
        return $this->role;
    }

    public function isHost(): bool
    {
        return $this->isHost;
    }

    public function isAlive(): bool
    {
        return $this->isAlive;
    }

    public function setAlive(bool $value): void
    {
        $this->isAlive = $value;
    }
}
