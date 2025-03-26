<?php

namespace App\Controller;

use App\Application\Command\CreateGameCommand;
use App\Application\Command\JoinGameCommand;
use App\Application\Command\NextPhaseCommand;
use App\Application\Command\StartGameCommand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractController
{
    use HandleTrait;

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

    #[Route('/game/create', name: 'game_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $hostName = $request->request->get('hostName');
        $command = new CreateGameCommand($hostName);
        $envelope = $this->messageBus->dispatch($command);

        return $this->redirectToRoute('lobby', ['code' => $hostName]);
    }

    #[Route('/game/join', name: 'game_join', methods: ['POST'])]
    public function join(Request $request): Response
    {
        $gameCode = $request->request->get('code');
        $playerName = $request->request->get('name');
        $command = new JoinGameCommand($gameCode, $playerName);
        $this->messageBus->dispatch($command);

        return $this->redirectToRoute('lobby', ['code' => $gameCode]);
    }

    #[Route('/game/start', name: 'game_start', methods: ['POST'])]
    public function start(Request $request): Response
    {
        $gameCode = $request->request->get('code');
        $command = new StartGameCommand($gameCode);
        $this->messageBus->dispatch($command);
        return $this->redirectToRoute('game_play', ['code' => $gameCode]);
    }

    #[Route('/game/next-phase', name: 'game_next_phase', methods: ['POST'])]
    public function nextPhase(Request $request): Response
    {
        $gameCode = $request->request->get('code');
        $command = new NextPhaseCommand($gameCode);
        $this->messageBus->dispatch($command);

        return $this->redirectToRoute('game_play', ['code' => $gameCode]);
    }
}
