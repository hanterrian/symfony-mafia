<?php

namespace App\Entity;

use App\Enum\PlayerRole;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity]
#[ORM\Table(name: "players")]
class Player
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private string $name;

    #[ORM\Column]
    private bool $isAlive = true;

    #[ORM\ManyToOne(targetEntity: Game::class, inversedBy: "players")]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private Game $game;

    #[ORM\Column(type: "string", enumType: PlayerRole::class)]
    private PlayerRole $role;

    #[ORM\OneToMany(mappedBy: "sender", targetEntity: Message::class, cascade: ["remove"])]
    private Collection $messages;

    #[ORM\OneToMany(mappedBy: "voter", targetEntity: Vote::class, cascade: ["remove"])]
    private Collection $votes;
    public function __construct(Game $game, string $name, PlayerRole $role)
    {
        $this->game = $game;
        $this->name = $name;
        $this->role = $role;
        $this->messages = new ArrayCollection();
        $this->votes = new ArrayCollection();
    }

    public function isMafia(): bool
    {
        return $this->role === PlayerRole::MAFIA;
    }

    public function getId(): ?int
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

    public function isAlive(): ?bool
    {
        return $this->isAlive;
    }

    public function setIsAlive(bool $isAlive): static
    {
        $this->isAlive = $isAlive;

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

    public function getGame(): ?Game
    {
        return $this->game;
    }

    public function setGame(?Game $game): static
    {
        $this->game = $game;

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setSender($this);
        }

        return $this;
    }

    public function removeMessage(Message $message): static
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getSender() === $this) {
                $message->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): static
    {
        if (!$this->votes->contains($vote)) {
            $this->votes->add($vote);
            $vote->setVoter($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): static
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getVoter() === $this) {
                $vote->setVoter(null);
            }
        }

        return $this;
    }
}
