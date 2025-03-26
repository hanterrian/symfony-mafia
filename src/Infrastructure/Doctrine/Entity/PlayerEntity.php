<?php

namespace App\Infrastructure\Doctrine\Entity;


use App\Domain\Enum\PlayerRole;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'players')]
class PlayerEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $id;

    #[ORM\Column(length: 100)]
    private string $name;

    #[ORM\Column(type: 'string', enumType: PlayerRole::class)]
    private PlayerRole $role;

    #[ORM\Column(type: 'boolean')]
    private bool $isAlive = true;

    #[ORM\Column(type: 'boolean')]
    private bool $isHost = false;

    #[ORM\ManyToOne(targetEntity: GameEntity::class, inversedBy: 'players')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private GameEntity $game;

    public function __construct(string $id, string $name, PlayerRole $role, GameEntity $game, bool $isHost = false)
    {
        $this->id = $id;
        $this->name = $name;
        $this->role = $role;
        $this->game = $game;
        $this->isHost = $isHost;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getRole(): ?PlayerRole
    {
        return $this->role;
    }

    public function setRole(PlayerRole $role): static
    {
        $this->role = $role;

        return $this;
    }

    public function isAlive(): ?bool
    {
        return $this->isAlive;
    }

    public function setIsAlive(bool $isAlive): static
    {
        $this->isAlive = $isAlive;

        return $this;
    }

    public function isHost(): ?bool
    {
        return $this->isHost;
    }

    public function setIsHost(bool $isHost): static
    {
        $this->isHost = $isHost;

        return $this;
    }

    public function getGame(): ?GameEntity
    {
        return $this->game;
    }

    public function setGame(?GameEntity $game): static
    {
        $this->game = $game;

        return $this;
    }
}
