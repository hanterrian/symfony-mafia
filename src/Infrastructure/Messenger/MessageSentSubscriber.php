<?php

namespace App\Infrastructure\Messenger;

use App\Domain\Event\MessageSent;
use Symfony\Component\Mercure\HubInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler(fromTransport: null)]
class MessageSentSubscriber
{
    public function __construct(private HubInterface $hub)
    {
    }

    public function __invoke(MessageSent $event): void
    {
        $update = new Update(
            topics: ["/game/{$event->gameCode}/chat/{$event->chatType->value}"],
            data  : json_encode([
                'type'      => 'message',
                'sender'    => $event->senderName,
                'content'   => $event->content,
                'timestamp' => $event->timestamp->format(DATE_ATOM),
            ])
        );

        $this->hub->publish($update);
    }
}
