<?php

namespace App\Infrastructure\Messenger;

use App\Domain\Event\PhaseChanged;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: null)]
class PhaseChangedSubscriber
{
    public function __construct(private HubInterface $hub)
    {
    }

    public function __invoke(PhaseChanged $event): void
    {
        $update = new Update(
            topics: ["/game/{$event->gameCode}/phase"],
            data  : json_encode([
                'type'      => 'phase_changed',
                'gameId'    => $event->gameId,
                'gameCode'  => $event->gameCode,
                'newStatus' => $event->newStatus->value,
            ])
        );

        $this->hub->publish($update);
    }
}
