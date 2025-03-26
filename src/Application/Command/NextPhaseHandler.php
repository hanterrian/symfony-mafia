<?php

namespace App\Application\Command;

use App\Domain\Enum\GameStatus;
use App\Domain\Event\PhaseChanged;
use App\Domain\Repository\GameRepositoryInterface;
use DomainException;
use Symfony\Component\Messenger\MessageBusInterface;

class NextPhaseHandler
{
    public function __construct(
        private GameRepositoryInterface $repository,
        private MessageBusInterface     $eventBus // event.bus
    )
    {
    }

    public function __invoke(NextPhaseCommand $command): void
    {
        $game = $this->repository->findByCode($command->gameCode);
        if (!$game) {
            throw new DomainException('Game not found.');
        }

        $next = match ($game->getStatus()) {
            GameStatus::NIGHT  => GameStatus::DAY,
            GameStatus::DAY    => GameStatus::VOTING,
            GameStatus::VOTING => GameStatus::NIGHT,
            default            => GameStatus::FINISHED,
        };

        $game->setStatus($next);
        $this->repository->save($game);

        $this->eventBus->dispatch(
            new PhaseChanged(
                $game->getId(),
                $game->getCode(),
                $next
            )
        );
    }
}
