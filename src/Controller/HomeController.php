<?php

namespace App\Controller;

use App\Form\CreateGameType;
use App\Form\JoinGameType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $createForm = $this->createForm(CreateGameType::class, null, [
            'action' => $this->generateUrl('app_create_game'),
            'method' => 'POST',
        ]);
        $joinForm = $this->createForm(JoinGameType::class, null, [
            'action' => $this->generateUrl('app_join_game'),
            'method' => 'POST',
        ]);

        return $this->render('home/index.html.twig', [
            'createForm' => $createForm->createView(),
            'joinForm'   => $joinForm->createView(),
        ]);
    }

    #[Route('/create-game', name: 'app_create_game')]
    public function createGame(): Response
    {
        return $this->redirectToRoute('app_home');
    }

    #[Route('/join-game', name: 'app_join_game')]
    public function joinGame(): Response
    {
        return $this->redirectToRoute('app_home');
    }
}
