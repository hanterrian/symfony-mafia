<?php

namespace App\Application\Command;

use App\Domain\Enum\GameStatus;
use App\Domain\Enum\PlayerRole;
use App\Domain\Game\Game;
use App\Domain\Player\Player;
use App\Domain\Repository\GameRepositoryInterface;
use Symfony\Component\Uid\Uuid;

class CreateGameHandler
{
    public function __construct(private GameRepositoryInterface $repository)
    {
    }

    public function __invoke(CreateGameCommand $command): string
    {
        $game = new Game(
            id      : Uuid::v4()->toRfc4122(),
            code    : Uuid::v4()->toRfc4122(),
            hostName: $command->hostName,
            status  : GameStatus::LOBBY
        );

        $host = new Player(
            id    : Uuid::v4()->toRfc4122(),
            name  : $command->hostName,
            role  : PlayerRole::HOST,
            isHost: true
        );

        $game->addPlayer($host);
        $this->repository->save($game);

        return $game->getCode();
    }
}
