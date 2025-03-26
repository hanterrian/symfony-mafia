<?php

namespace App\Application\Command;

use App\Domain\Event\MessageSent;
use App\Domain\Repository\GameRepositoryInterface;
use DateTimeImmutable;
use DomainException;
use Symfony\Component\Messenger\MessageBusInterface;

class SendMessageHandler
{
    public function __construct(
        private GameRepositoryInterface $repository,
        private MessageBusInterface     $eventBus
    )
    {
    }

    public function __invoke(SendMessageCommand $command): void
    {
        $game = $this->repository->findByCode($command->gameCode);
        if (!$game) {
            throw new DomainException('Game not found.');
        }

        $player = null;
        foreach ($game->getPlayers() as $p) {
            if ($p->getName() === $command->senderName) {
                $player = $p;
                break;
            }
        }

        if (!$player || !$player->isAlive()) {
            throw new DomainException('Player not allowed to send message.');
        }

        $event = new MessageSent(
            gameCode  : $command->gameCode,
            senderName: $player->getName(),
            content   : $command->content,
            chatType  : $command->chatType,
            timestamp : new DateTimeImmutable()
        );

        $this->eventBus->dispatch($event);
    }
}
