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
        $createForm = $this->createForm(CreateGameType::class);
        $joinForm = $this->createForm(JoinGameType::class);

        if ($createForm->isSubmitted() && $createForm->isValid()) {
        }

        if ($joinForm->isSubmitted() && $joinForm->isValid()) {
        }

        return $this->render('home/index.html.twig', [
            'createForm' => $createForm->createView(),
            'joinForm'   => $joinForm->createView(),
        ]);
    }
}
