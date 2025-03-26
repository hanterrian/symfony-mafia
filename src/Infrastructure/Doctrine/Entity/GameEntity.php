<?php

namespace App\Infrastructure\Doctrine\Entity;


use App\Domain\Enum\GameStatus;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: 'games')]
class GameEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $id;

    #[ORM\Column(length: 100, unique: true)]
    private string $code;

    #[ORM\Column(length: 255)]
    private string $hostName;

    #[ORM\Column(type: 'string', enumType: GameStatus::class)]
    private GameStatus $status;

    #[ORM\OneToMany(
        mappedBy     : 'game',
        targetEntity : PlayerEntity::class,
        cascade      : ['persist', 'remove',],
        orphanRemoval: true
    )]
    private Collection $players;

    public function __construct(string $id, string $code, string $hostName)
    {
        $this->id = $id;
        $this->code = $code;
        $this->hostName = $hostName;
        $this->status = GameStatus::LOBBY;
        $this->players = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getHostName(): ?string
    {
        return $this->hostName;
    }

    public function setHostName(string $hostName): static
    {
        $this->hostName = $hostName;

        return $this;
    }

    public function getStatus(): ?GameStatus
    {
        return $this->status;
    }

    public function setStatus(GameStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, PlayerEntity>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(PlayerEntity $player): static
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
            $player->setGame($this);
        }

        return $this;
    }

    public function removePlayer(PlayerEntity $player): static
    {
        if ($this->players->removeElement($player)) {
            // set the owning side to null (unless already changed)
            if ($player->getGame() === $this) {
                $player->setGame(null);
            }
        }

        return $this;
    }
}
