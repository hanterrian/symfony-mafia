<?php

namespace App\Infrastructure\Doctrine\Entity;

use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'votes')]
class VoteEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $id;

    #[ORM\ManyToOne(targetEntity: GameEntity::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private GameEntity $game;

    #[ORM\ManyToOne(targetEntity: PlayerEntity::class)]
    #[ORM\JoinColumn(nullable: false)]
    private PlayerEntity $voter;

    #[ORM\ManyToOne(targetEntity: PlayerEntity::class)]
    #[ORM\JoinColumn(nullable: true)]
    private ?PlayerEntity $target = null;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(type: 'boolean')]
    private bool $isFinal = false;

    public function __construct(string $id, GameEntity $game, PlayerEntity $voter, ?PlayerEntity $target = null)
    {
        $this->id = $id;
        $this->game = $game;
        $this->voter = $voter;
        $this->target = $target;
        $this->createdAt = new DateTime();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isFinal(): ?bool
    {
        return $this->isFinal;
    }

    public function setIsFinal(bool $isFinal): static
    {
        $this->isFinal = $isFinal;

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

    public function getVoter(): ?PlayerEntity
    {
        return $this->voter;
    }

    public function setVoter(?PlayerEntity $voter): static
    {
        $this->voter = $voter;

        return $this;
    }

    public function getTarget(): ?PlayerEntity
    {
        return $this->target;
    }

    public function setTarget(?PlayerEntity $target): static
    {
        $this->target = $target;

        return $this;
    }
}
