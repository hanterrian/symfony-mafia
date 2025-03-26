<?php

namespace App\Controller;

use App\Application\Command\SendMessageCommand;
use App\Domain\Enum\ChatType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

class ChatController extends AbstractController
{
    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    #[Route('/game/{code}/chat/send', name: 'chat_send', methods: ['POST'])]
    public function send(string $code, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        if (!isset($data['name'], $data['content'])) {
            return new JsonResponse(['error' => 'Invalid request'], 400);
        }

        $chatType = isset($data['chatType']) && $data['chatType'] === 'mafia'
            ? ChatType::MAFIA
            : ChatType::GENERAL;

        $command = new SendMessageCommand(
            gameCode  : $code,
            senderName: $data['name'],
            content   : $data['content'],
            chatType  : $chatType
        );

        $this->messageBus->dispatch($command);

        return new JsonResponse(['status' => 'ok']);
    }
}
