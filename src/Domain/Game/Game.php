<?php

namespace App\Domain\Game;

use App\Domain\Enum\GameStatus;
use App\Domain\Player\Player;

class Game
{
    private string     $id;
    private string     $code;
    private string     $hostName;
    private GameStatus $status;
    /** @var Player[] */
    private array $players = [];

    public function __construct(string $id, string $code, string $hostName, GameStatus $status = GameStatus::LOBBY)
    {
        $this->id = $id;
        $this->code = $code;
        $this->hostName = $hostName;
        $this->status = $status;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function getHostName(): string
    {
        return $this->hostName;
    }

    public function getStatus(): GameStatus
    {
        return $this->status;
    }

    public function setStatus(GameStatus $status): void
    {
        $this->status = $status;
    }

    public function addPlayer(Player $player): void
    {
        $this->players[] = $player;
    }

    public function getPlayers(): array
    {
        return $this->players;
    }
}
