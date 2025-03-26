<?php

namespace App\Application\Command;

use App\Domain\Enum\GameStatus;
use App\Domain\Enum\PlayerRole;
use App\Domain\Event\GameStarted;
use App\Domain\Repository\GameRepositoryInterface;
use DomainException;
use Symfony\Component\Messenger\MessageBusInterface;

class StartGameHandler
{
    public function __construct(
        private GameRepositoryInterface $repository,
        private MessageBusInterface     $eventBus // event.bus
    )
    {
    }

    public function __invoke(StartGameCommand $command): void
    {
        $game = $this->repository->findByCode($command->gameCode);
        if (!$game) {
            throw new \DomainException('Game not found.');
        }

        $players = array_filter($game->getPlayers(), fn($p) => !$p->isHost());
        shuffle($players);

        $roles = [
            PlayerRole::MAFIA,
            PlayerRole::MAFIA,
            PlayerRole::DOCTOR,
            PlayerRole::SHERIFF,
        ];

        foreach ($players as $i => $player) {
            $player->setRole($roles[$i] ?? PlayerRole::CIVILIAN);
        }

        $game->setStatus(GameStatus::NIGHT);
        $this->repository->save($game);

        $this->eventBus->dispatch(new GameStarted($game->getId(), $game->getCode()));
    }
}
