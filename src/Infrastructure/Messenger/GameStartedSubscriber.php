<?php

namespace App\Infrastructure\Messenger;

use App\Domain\Event\GameStarted;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: null)]
class GameStartedSubscriber
{
    public function __construct(private HubInterface $hub)
    {
    }

    public function __invoke(GameStarted $event): void
    {
        $update = new Update(
            topics: "/game/{$event->gameCode}",
            data  : json_encode([
                'type'     => 'game_started',
                'gameId'   => $event->gameId,
                'gameCode' => $event->gameCode,
                'message'  => 'The game has started. Night phase begins.',
            ])
        );

        $this->hub->publish($update);
    }
}
