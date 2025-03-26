<?php

namespace App\Application\Command;

use App\Domain\Enum\PlayerRole;
use App\Domain\Player\Player;
use App\Domain\Repository\GameRepositoryInterface;
use DomainException;
use Symfony\Component\Uid\Uuid;

class JoinGameHandler
{
    public function __construct(private GameRepositoryInterface $repository)
    {
    }

    public function __invoke(JoinGameCommand $command): void
    {
        $game = $this->repository->findByCode($command->gameCode);
        if (!$game) {
            throw new DomainException('Game not found.');
        }

        $player = new Player(
            id  : Uuid::v4()->toRfc4122(),
            name: $command->playerName,
            role: PlayerRole::CIVILIAN
        );

        $game->addPlayer($player);
        $this->repository->save($game);
    }
}
