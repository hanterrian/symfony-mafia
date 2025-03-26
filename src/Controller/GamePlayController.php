<?php

namespace App\Controller;

use App\Domain\Repository\GameRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GamePlayController extends AbstractController
{
    #[Route('/gameplay/{code}', name: 'game_play', methods: ['GET'])]
    public function play(string $code, Request $request, GameRepositoryInterface $repo): Response
    {
        $game = $repo->findByCode($code);
        if (!$game) {
            throw $this->createNotFoundException('Game not found.');
        }

        $playerName = $request->query->get('name');
        $currentPlayer = null;

        foreach ($game->getPlayers() as $player) {
            if ($player->getName() === $playerName) {
                $currentPlayer = $player;
                break;
            }
        }

        return $this->render('gameplay/index.html.twig', [
            'game'   => $game,
            'player' => $currentPlayer,
        ]);
    }
}
