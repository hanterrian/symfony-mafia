<?php

namespace App\Infrastructure\Doctrine\Entity;

use App\Domain\Enum\ChatType;
use DateTime;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'messages')]
class MessageEntity
{
    #[ORM\Id]
    #[ORM\Column(type: 'guid')]
    private string $id;

    #[ORM\ManyToOne(targetEntity: GameEntity::class)]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private GameEntity $game;

    #[ORM\ManyToOne(targetEntity: PlayerEntity::class)]
    #[ORM\JoinColumn(nullable: false)]
    private PlayerEntity $sender;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column(type: 'datetime')]
    private DateTime $createdAt;

    #[ORM\Column(type: 'string', enumType: ChatType::class)]
    private ChatType $chatType;

    public function __construct(string $id, GameEntity $game, PlayerEntity $sender, string $content, ChatType $chatType)
    {
        $this->id = $id;
        $this->game = $game;
        $this->sender = $sender;
        $this->content = $content;
        $this->chatType = $chatType;
        $this->createdAt = new DateTime();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
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

    public function getChatType(): ?ChatType
    {
        return $this->chatType;
    }

    public function setChatType(ChatType $chatType): static
    {
        $this->chatType = $chatType;

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

    public function getSender(): ?PlayerEntity
    {
        return $this->sender;
    }

    public function setSender(?PlayerEntity $sender): static
    {
        $this->sender = $sender;

        return $this;
    }
}
